#!/usr/bin/env python3
"""Rebuild Filament resource forms with logical section grouping and columns."""

from __future__ import annotations

import json
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
RES = ROOT / "app" / "Filament" / "Resources"

# Field name -> logical section key
SECTION_RULES: list[tuple[str, list[str]]] = [
    (
        "relations",
        [
            r".*_id$",
            r"^(requested_by|assigned_to|created_by|updated_by|approved_by|reviewed_by|inspector_id|driver_id|supervisor_id|parent_id|user_id|employee_id|center_id|company_id|vehicle_id|role_id|workflow_id)$",
        ],
    ),
    (
        "identity",
        [
            r"^(code|name|title|request_number|personnel_code|national_code|id_card_number|id_card_serial|first_name|last_name|father_name|brand|model|plate_number|serial_number|license_number|username|email|phone|mobile)$",
            r"^(university|population_served|logo|slug|label|display_name)$",
        ],
    ),
    (
        "location",
        [
            r"^(province|city|district|address|postal_code|location|origin|destination|gps_lat|gps_lng|latitude|longitude|lat|lng|geo_.*)$",
            r"^(working_hours_start|working_hours_end|working_days|emergency_hours)$",
            r"^(area_sqm|floors|rooms_count|parking_spaces|generator_power_kw)$",
            r"^(fax|website)$",
        ],
    ),
    (
        "status",
        [
            r"^(status|type|priority|gender|marital_status|ethnicity|facility_type|service_type|trip_purpose|level|category|is_active|active|enabled)$",
            r"^(birth_place)$",
        ],
    ),
    (
        "dates",
        [
            r".*_date$",
            r".*_at$",
            r"^(date|birth_date|employment_date|end_date|start_date|valid_from|valid_to|preferred_time|completion_date|departure_datetime|expected_return|check_in|check_out|probation_end_date|contract_end_date|retirement_date|established_date|license_expiry)$",
            r"^(years_of_service)$",
        ],
    ),
    (
        "finance",
        [
            r"^(cost|amount|price|budget|budget_approval|salary|fee|total|quantity|unit_price|balance|credit|debit)$",
            r".*_cost$",
            r".*_amount$",
        ],
    ),
    (
        "description",
        [
            r"^(description|notes|note|comment|comments|details|problem_description|error_messages|body|content|summary|remark|remarks)$",
        ],
    ),
]

SECTION_META = {
    "identity": ("اطلاعات اصلی", 2),
    "relations": ("ارتباطات", 2),
    "location": ("مکان و تماس", 2),
    "status": ("وضعیت و نوع", 2),
    "dates": ("تاریخ‌ها", 2),
    "finance": ("مالی و مقادیر", 2),
    "description": ("توضیحات", 1),
    "other": ("سایر اطلاعات", 2),
}

# Force certain fields into a section regardless of order of rules
FORCE = {
    "gps_lat": "location",
    "gps_lng": "location",
    "latitude": "location",
    "longitude": "location",
    "lat": "location",
    "lng": "location",
    "province": "location",
    "city": "location",
    "district": "location",
    "address": "location",
    "postal_code": "location",
    "phone": "location",
    "fax": "location",
    "email": "identity",
    "website": "location",
    "first_name": "identity",
    "last_name": "identity",
    "father_name": "identity",
    "national_code": "identity",
    "personnel_code": "identity",
    "birth_date": "dates",
    "employment_date": "dates",
    "end_date": "dates",
    "preferred_time": "dates",
    "completion_date": "dates",
    "departure_datetime": "dates",
    "expected_return": "dates",
    "origin": "location",
    "destination": "location",
    "cost": "finance",
    "budget_approval": "finance",
    "description": "description",
    "notes": "description",
    "problem_description": "description",
    "error_messages": "description",
    "parent_id": "relations",
    "center_id": "relations",
    "employee_id": "relations",
    "company_id": "relations",
    "requested_by": "relations",
    "assigned_to": "relations",
    "vehicle_id": "relations",
    "driver_id": "relations",
    "supervisor_id": "relations",
    "type": "status",
    "status": "status",
    "priority": "status",
    "gender": "status",
    "marital_status": "status",
    "facility_type": "status",
    "service_type": "status",
    "trip_purpose": "status",
    "location": "location",
    "working_hours_start": "location",
    "working_hours_end": "location",
    "working_days": "location",
    "emergency_hours": "location",
    "area_sqm": "location",
    "floors": "location",
    "rooms_count": "location",
    "parking_spaces": "location",
    "generator_power_kw": "location",
    "population_served": "identity",
    "university": "identity",
    "logo": "identity",
    "license_number": "identity",
    "established_date": "dates",
    "license_expiry": "dates",
    "passenger_count": "other",
    "ethnicity": "status",
    "birth_place": "identity",
    "id_card_number": "identity",
    "id_card_serial": "identity",
    "years_of_service": "dates",
    "probation_end_date": "dates",
    "contract_end_date": "dates",
    "retirement_date": "dates",
    "has_elevator": "location",
    "has_generator": "location",
    "has_fire_system": "location",
    "has_cctv": "location",
    "building_type": "status",
    "accreditation_level": "status",
    "service_area_type": "status",
    "level": "status",
}


def classify(name: str) -> str:
    if name in FORCE:
        return FORCE[name]
    for section, patterns in SECTION_RULES:
        for pat in patterns:
            if re.search(pat, name):
                return section
    return "other"


def extract_fields(form_body: str) -> list[dict]:
    starts = list(re.finditer(r"Forms\\Components\\[A-Za-z0-9_]+::make\('([^']+)'\)", form_body))
    fields: list[dict] = []
    for i, m in enumerate(starts):
        start = m.start()
        end = starts[i + 1].start() if i + 1 < len(starts) else len(form_body)
        chunk = form_body[start:end]
        chunk = re.split(r"\n\s*\]\s*\)", chunk)[0]
        chunk = chunk.rstrip().rstrip(",")
        # drop accidental trailing section meta
        chunk = re.sub(r"\n\s*->columns\(\d+\)\s*$", "", chunk)
        fields.append({"name": m.group(1), "code": chunk})
    return fields


def build_form(fields: list[dict]) -> str:
    grouped: dict[str, list[dict]] = {}
    order = ["identity", "relations", "location", "status", "dates", "finance", "description", "other"]
    for f in fields:
        sec = classify(f["name"])
        grouped.setdefault(sec, []).append(f)

    # Preferred field order inside location for lat/lng adjacency
    def sort_key(section: str, name: str) -> tuple:
        if section == "location":
            pref = [
                "province", "city", "district", "address", "postal_code",
                "gps_lat", "gps_lng", "latitude", "longitude", "lat", "lng",
                "phone", "fax", "website", "location", "origin", "destination",
                "working_hours_start", "working_hours_end", "working_days", "emergency_hours",
                "area_sqm", "floors", "rooms_count", "parking_spaces", "generator_power_kw",
            ]
            return (pref.index(name) if name in pref else 100 + hash(name) % 50, name)
        if section == "identity":
            pref = [
                "code", "personnel_code", "request_number", "name", "title",
                "first_name", "last_name", "father_name", "national_code",
                "id_card_number", "id_card_serial", "birth_place",
                "university", "population_served", "license_number", "email", "logo",
            ]
            return (pref.index(name) if name in pref else 100, name)
        if section == "dates":
            pref = [
                "birth_date", "employment_date", "established_date", "start_date",
                "preferred_time", "departure_datetime", "check_in",
                "completion_date", "expected_return", "check_out", "end_date",
                "probation_end_date", "contract_end_date", "retirement_date",
                "license_expiry", "valid_from", "valid_to", "years_of_service",
            ]
            return (pref.index(name) if name in pref else 100, name)
        return (0, name)

    blocks: list[str] = []
    for sec in order:
        items = grouped.get(sec) or []
        if not items:
            continue
        items = sorted(items, key=lambda x: sort_key(sec, x["name"]))
        title, cols = SECTION_META[sec]
        if len(items) == 1:
            cols = 1
        field_code = ",\n".join("                    " + it["code"].replace("\n", "\n                    ") for it in items)
        # normalize indentation of field code: each field already starts at component
        # rebuild cleaner
        parts = []
        for it in items:
            code = it["code"]
            # reindent: first line 20 spaces, subsequent keep relative
            lines = code.splitlines()
            if not lines:
                continue
            first = "                    " + lines[0].lstrip()
            rest = []
            for ln in lines[1:]:
                rest.append("                        " + ln.lstrip() if ln.strip() else "")
            parts.append("\n".join([first] + rest))
        inner = ",\n".join(parts)
        block = (
            f"            Section::make('{title}')\n"
            f"                ->columns({cols})\n"
            f"                ->schema([\n"
            f"{inner},\n"
            f"                ])"
        )
        blocks.append(block)

    joined = ",\n".join(blocks)
    return (
        "    public static function form(Schema $schema): Schema\n"
        "    {\n"
        "        return $schema\n"
        "            ->columns(1)\n"
        "            ->schema([\n"
        f"{joined},\n"
        "            ]);\n"
        "    }"
    )


def process_file(path: Path) -> bool:
    text = path.read_text(encoding="utf-8")
    m = re.search(
        r"public static function form\(Schema \$schema\): Schema\s*\{.*?\n    public static function (?:table|getRelations|getPages)",
        text,
        re.S,
    )
    if not m:
        return False
    full = m.group(0)
    # body only for extraction
    body_m = re.search(r"function form\(Schema \$schema\): Schema\s*\{(.*)\n    public static function (?:table|getRelations|getPages)", full, re.S)
    if not body_m:
        return False
    fields = extract_fields(body_m.group(1))
    if not fields:
        return False
    new_form = build_form(fields)
    # replace form method only (keep the following method signature start)
    tail_m = re.search(r"\n    public static function (table|getRelations|getPages)", full)
    assert tail_m
    replacement = new_form + "\n\n    public static function " + tail_m.group(1)
    # original matched up to method name without rest - we need careful replace
    # Match form method exclusively
    form_only = re.search(
        r"public static function form\(Schema \$schema\): Schema\s*\{.*?\n    (?=public static function (?:table|getRelations|getPages))",
        text,
        re.S,
    )
    if not form_only:
        return False
    new_text = text[: form_only.start()] + new_form + "\n\n    " + text[form_only.end():]
    if new_text != text:
        path.write_text(new_text, encoding="utf-8")
        return True
    return False


def main() -> None:
    changed = []
    inventory = {}
    for path in sorted(RES.glob("*Resource.php")):
        text = path.read_text(encoding="utf-8")
        m = re.search(r"function form\(Schema \$schema\): Schema\s*\{(.*?)(\n    public static function (?:table|getRelations|getPages))", text, re.S)
        if not m:
            continue
        fields = extract_fields(m.group(1))
        inventory[path.name] = {
            "count": len(fields),
            "names": [f["name"] for f in fields],
            "groups": {},
        }
        for f in fields:
            g = classify(f["name"])
            inventory[path.name]["groups"].setdefault(g, []).append(f["name"])
        if process_file(path):
            changed.append(path.name)

    (ROOT / "_form_rebuild_report.json").write_text(
        json.dumps({"changed": changed, "inventory": inventory}, ensure_ascii=False, indent=2),
        encoding="utf-8",
    )
    print(f"changed={len(changed)}")
    print(f"total_with_form={len(inventory)}")
    # sanity center
    c = inventory.get("CenterResource.php", {})
    print("center_groups", {k: v for k, v in c.get("groups", {}).items()})


if __name__ == "__main__":
    main()
