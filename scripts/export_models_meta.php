<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$out = [];

foreach (glob(__DIR__ . '/../app/Models/*.php') as $file) {
    $short = basename($file, '.php');
    $class = 'App\\Models\\' . $short;

    require_once $file;

    if (! class_exists($class)) {
        echo "no class {$short}\n";
        continue;
    }

    try {
        $ref = new ReflectionClass($class);
        if ($ref->isAbstract()) {
            continue;
        }

        /** @var Illuminate\Database\Eloquent\Model $m */
        $m = new $class;
        $table = $m->getTable();
        $fillable = $m->getFillable();
        $casts = $m->getCasts();
        $cols = [];
        $colTypes = [];

        try {
            if (Illuminate\Support\Facades\Schema::hasTable($table)) {
                $cols = Illuminate\Support\Facades\Schema::getColumnListing($table);
                foreach ($cols as $c) {
                    try {
                        $colTypes[$c] = Illuminate\Support\Facades\Schema::getColumnType($table, $c);
                    } catch (Throwable $e) {
                        $colTypes[$c] = 'string';
                    }
                }
            }
        } catch (Throwable $e) {
            // ignore
        }

        $relations = [];
        foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->class !== $class) {
                continue;
            }
            if ($method->getNumberOfRequiredParameters() > 0) {
                continue;
            }

            $name = $method->getName();
            if (str_starts_with($name, '__')) {
                continue;
            }
            if (preg_match('/^(get|set|scope|new|resolve|boot|toArray|toJson|jsonSerialize)/', $name)) {
                continue;
            }

            try {
                $rel = $method->invoke($m);
                if ($rel instanceof Illuminate\Database\Eloquent\Relations\Relation) {
                    $relations[$name] = [
                        'type' => class_basename($rel),
                        'related_short' => class_basename($rel->getRelated()),
                        'related' => get_class($rel->getRelated()),
                        'foreign_key' => method_exists($rel, 'getForeignKeyName') ? $rel->getForeignKeyName() : null,
                    ];
                }
            } catch (Throwable $e) {
                // skip
            }
        }

        $out[] = [
            'short' => $short,
            'class' => $class,
            'table' => $table,
            'fillable' => $fillable,
            'casts' => $casts,
            'columns' => $cols,
            'column_types' => $colTypes,
            'relations' => $relations,
        ];
    } catch (Throwable $e) {
        echo "ERR {$short}: {$e->getMessage()}\n";
    }
}

$path = __DIR__ . '/../storage/app/models_meta.json';
file_put_contents($path, json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo 'wrote ' . count($out) . " models\n";

$withRel = array_filter($out, fn ($m) => count($m['relations']) > 0);
echo 'with relations: ' . count($withRel) . "\n";

foreach ($out as $m) {
    if ($m['short'] === 'Employee') {
        echo 'Employee relations: ' . json_encode($m['relations'], JSON_UNESCAPED_UNICODE) . "\n";
        echo 'Employee cols=' . count($m['columns']) . ' fillable=' . count($m['fillable']) . "\n";
    }
}
