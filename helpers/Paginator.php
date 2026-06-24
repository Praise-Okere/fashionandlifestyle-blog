<?php
// helpers/Paginator.php

class Paginator {
    private $limit;
    private $page;
    private $total;

    public function __construct($total, $page = 1, $limit = 10) {
        $this->total = $total;
        $this->page = max(1, (int)$page);
        $this->limit = max(1, (int)$limit);
    }

    public function getOffset() {
        return ($this->page - 1) * $this->limit;
    }

    public function getTotalPages() {
        return ceil($this->total / $this->limit);
    }

    public function createLinks($baseUrl) {
        $totalPages = $this->getTotalPages();
        if ($totalPages <= 1) return '';

        $html = '<ul class="pagination">';
        
        $prevClass = ($this->page == 1) ? 'disabled' : '';
        $prevUrl = ($this->page > 1) ? $baseUrl . '&page=' . ($this->page - 1) : '#';
        $html .= '<li class="page-item ' . $prevClass . '"><a class="page-link" href="' . $prevUrl . '">&laquo; Prev</a></li>';
        
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($this->page == $i) ? 'active' : '';
            $url = $baseUrl . '&page=' . $i;
            $html .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
        }
        
        $nextClass = ($this->page == $totalPages) ? 'disabled' : '';
        $nextUrl = ($this->page < $totalPages) ? $baseUrl . '&page=' . ($this->page + 1) : '#';
        $html .= '<li class="page-item ' . $nextClass . '"><a class="page-link" href="' . $nextUrl . '">Next &raquo;</a></li>';
        
        $html .= '</ul>';
        return $html;
    }
}
