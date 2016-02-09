<?php

function pagination($total, $limit, $base = null, $param = 'page', $display = 5) {

    if (empty($base)) {
        $base = current_url();
    }

    $page  = (int) get_param($param, 1);

    $pages = ceil($total / $limit);
    $items = array();

    if ($pages <= 1) {
        return;
    }

    $url  = append_url($base, $param.'=1');
    $items[] = sprintf('<li><a href="%s" data-push="1"><i class="icon fa-angle-double-left"></i></a></li>', $url);
    
    $prev = $page - 1;
    $prev = $prev <= 0 ? 1 : $prev;
    $url  = append_url($base, $param.'='.$prev);
    
    $items[] = sprintf('<li><a href="%s" data-push="1"><i class="icon fa-angle-left"></i></a></li>', $url);

    if ($page > $pages) {
        $page = $pages;
    }

    if ($page < $display)  {
        $start = 1;
    } elseif ($page >= ($pages - floor($display / 2))) {
        $start = $pages - $display + 1;
    } elseif ($page >= $display) {
        $start = $page - floor($display / 2);
    }

    if ($page >= $display && ($start - 1) > 0)  {
        $url = append_url($base, $param.'='.($start - 1) );
        $items[] = sprintf('<li><a href="%s" data-push="1">...</a></li>', $url);
    }

    for ($i = $start; $i <= ($start + $display - 1); $i++) {

        if ($i > $pages) continue;

        $num = $i;

        $url = append_url($base, $param.'='.$num);

        if ($num == $page) {
            $url = "#";
        }

        $cls = $page == $num ? 'active' : '';

        $items[] = sprintf('<li class="%s"><a href="%s" data-push="1">%d</a></li>', $cls, $url, $num);
    }


    if (($start + $display) <= $pages ) {
        $url = append_url($base, $param.'='.($start + $display));
        $items[] = sprintf('<li><a href="%s" data-push="1">...</a></li>', $url, $pages);
    }

    $next = $page + 1;
    $next = $next >= $pages ? $pages : $next;
    
    $url  = append_url($base, $param.'='.$next);
    $items[] = sprintf('<li><a href="%s" data-push="1"><i class="icon fa-angle-right"></i></a></li>', $url);
    
    $url  = append_url($base, $param.'='.$pages);
    $items[] = sprintf('<li><a href="%s" data-push="1"><i class="icon fa-angle-double-right"></i></a></li>', $url);

    $html = '<ul class="pagination">' . implode('', $items) . '</ul>';

    return $html;
}