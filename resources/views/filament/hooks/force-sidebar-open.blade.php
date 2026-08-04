<script>
    (function () {
        // Fix stuck collapsed sidebar / groups from Alpine $persist localStorage
        try {
            const keys = Object.keys(localStorage);
            keys.forEach((key) => {
                if (
                    key === 'isOpen' ||
                    key === 'isOpenDesktop' ||
                    key === 'collapsedGroups' ||
                    key.includes('isOpen') ||
                    key.includes('collapsedGroups') ||
                    key.includes('sidebar')
                ) {
                    // keep theme
                    if (key === 'theme') return;
                    localStorage.removeItem(key);
                }
            });
            // force open defaults before Alpine boots
            localStorage.setItem('isOpen', 'true');
            localStorage.setItem('isOpenDesktop', 'true');
            localStorage.setItem('collapsedGroups', '[]');
        } catch (e) {}

        document.addEventListener('alpine:initialized', () => {
            try {
                const sidebar = window.Alpine && window.Alpine.store
                    ? window.Alpine.store('sidebar')
                    : null;
                if (!sidebar) return;
                sidebar.collapsedGroups = [];
                if (typeof sidebar.open === 'function') {
                    sidebar.open();
                } else {
                    sidebar.isOpen = true;
                    sidebar.isOpenDesktop = true;
                }
            } catch (e) {}
        });

        // Hide any leaked persist marker text if browser shows attributes as text nodes
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('body *').forEach((el) => {
                if (!el.childNodes) return;
                el.childNodes.forEach((node) => {
                    if (
                        node.nodeType === Node.TEXT_NODE &&
                        typeof node.textContent === 'string' &&
                        node.textContent.includes('topbar.end.panel-')
                    ) {
                        node.textContent = '';
                    }
                });
            });
        });
    })();
</script>
