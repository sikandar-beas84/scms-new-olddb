<?php
/*if (!function_exists('buildMenuTree')) {
    function buildMenuTree(array $menus)
    {
        $menuTree = [];
        $lookup = [];

        foreach ($menus as &$menu) {
            $menu['children'] = [];
            $lookup[$menu['id']] = &$menu;
        }
        unset($menu);

        foreach ($lookup as &$menu) {
            if ($menu['parent_id'] === null) {
                $menuTree[] = &$menu;
            } else {
                $lookup[$menu['parent_id']]['children'][] = &$menu;
            }
        }
        unset($menu);

        return $menuTree;
    }
}*/

if (!function_exists('buildMenuTree')) {
    function buildMenuTree(array $menus)
    {
        $menuTree = [];
        $lookup = [];

        // First pass: normalize data & build lookup
        foreach ($menus as &$menu) {
            $menu['children'] = [];

            // 🔐 Ensure parent_id key always exists
            $menu['parent_id'] = $menu['parent_id'] ?? null;

            $lookup[$menu['id']] = &$menu;
        }
        unset($menu);

        // Second pass: build tree
        foreach ($lookup as &$menu) {

            if ($menu['parent_id'] === null) {
                $menuTree[] = &$menu;
            } else {
                // 🔐 Check parent exists
                if (isset($lookup[$menu['parent_id']])) {
                    $lookup[$menu['parent_id']]['children'][] = &$menu;
                }
            }

        }
        unset($menu);

        return $menuTree;
    }
}


if (!function_exists('renderMenu')) {
    function renderMenu(array $items)
    {
        echo '<ul class="nav nav-sidebar" data-nav-type="accordion">';
        foreach ($items as $item) {
            renderMenuItem($item);
        }
        echo '</ul>';
    }
}

if (!function_exists('renderMenuItem')) {
    function renderMenuItem(array $item, $isChild = false)
    {
        $hasChildren = !empty($item['children']);
        // $icon = !empty($item['icon']) ? '<i class="' . esc($item['icon']) . '"></i>' : '<i class="ph-house"></i>';
        $icon = (!$isChild && !empty($item['icon']))
            ? '<i class="' . esc($item['icon']) . '"></i>'
            : (!$isChild ? '<i class="ph-house"></i>' : '');

        $url = !empty($item['url']) ? site_url($item['url']) : '#';

        // Current URL check
        $currentUrl = current_url();
        $isActive = ($url !== '#' && rtrim($currentUrl, '/') === rtrim($url, '/'));
        $isParentActive = hasActiveChild($item['children']);

        if ($hasChildren) {
            $liClass = 'nav-item nav-item-submenu';
            if ($isActive || $isParentActive) {
                $liClass .= ' nav-item-expanded nav-item-open';
            }

            echo '<li class="' . $liClass . '">';
            echo '<a href="#" class="nav-link">' . $icon . '<span>' . esc($item['title']) . '</span></a>';

            $ulClass = 'nav-group-sub collapse';
            if ($isActive || $isParentActive) {
                $ulClass .= ' show';
            }

            echo '<ul class="' . $ulClass . '">';
            foreach ($item['children'] as $child) {
                renderMenuItem($child, true);
            }
            echo '</ul>';
            echo '</li>';
        } else {
            $liClass = 'nav-item';
            $linkClass = 'nav-link';
            if ($isActive) {
                $linkClass .= ' active';
            }

            echo '<li class="' . $liClass . '">';
            echo '<a href="' . esc($url) . '" class="' . $linkClass . '">' . $icon . '<span>' . esc($item['title']) . '</span></a>';
            echo '</li>';
        }
    }
}

if (!function_exists('hasActiveChild')) {
    function hasActiveChild(array $children)
    {
        $currentUrl = rtrim(current_url(), '/');
        foreach ($children as $child) {
            $url = !empty($child['url']) ? rtrim(site_url($child['url']), '/') : '#';
            if ($url !== '#' && $currentUrl === $url) {
                return true;
            }
            if (!empty($child['children']) && hasActiveChild($child['children'])) {
                return true;
            }
        }
        return false;
    }
}
