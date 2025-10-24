<?php

class Pager
{
    protected $currentPage;
    protected $totalRecords;
    protected $pageSize;

    protected $filters;

    public function __construct($identifier)
    {
        $this->currentPage = 1;
        $this->pageSize = 20;

        $this->findCurrentPage($identifier);
        $this->findCurrentFilters($identifier);
    }

    private function returnInt($num)
    {
        if (is_numeric($num))
            return (int)$num;
        throw new Exception("Invalid Int Provided -- " . $num);
    }

    public function findCurrentPage($identifier)
    {
        $this->currentPage = 1;
        if (!empty($_GET['pageNumber'])) {
            $this->currentPage = $this->returnInt($_GET['pageNumber']);
        } else if (!empty($_SESSION[$identifier . '-pageNumber'])) {
            $this->currentPage = $this->returnInt($_SESSION[$identifier . '-pageNumber']);
        }
        $_SESSION[$identifier . '-pageNumber'] = $this->currentPage();
    }

    public function findCurrentFilters($identifier)
    {
        $getFromSession = true;
        $this->filters = new stdClass();
        if (!empty($_GET)) {
            foreach ($_GET as $param => $val) {
                if ($param !== "pageNumber") {
                    $query = "pageFilter";
                    if (substr($param, 0, strlen($query)) === $query) {
                        $filter = substr($param, strlen($query), strlen($param) - strlen($query));
                        $this->filters->{$filter} = $val;
                        $getFromSession = false;
                    }
                }
            }
        }
        if ($getFromSession && !empty($_SESSION[$identifier . '-pageFilter'])) {
            $this->filters = json_decode($_SESSION[$identifier . '-pageFilter']);
        }
        $_SESSION[$identifier . '-pageFilter'] = json_encode($this->filters);
    }

    //

    public function setTotalRecords($num)
    {
        $this->totalRecords = $this->returnInt($num);
        if ($this->currentPage() > $this->MaxPage()) {
            $this->currentPage = $this->MaxPage();
        }
    }

    //

    public function currentPage()
    {
        return $this->currentPage;
    }
    public function pageSize()
    {
        return $this->pageSize;
    }
    public function Offset()
    {
        return ($this->pageSize * $this->currentPage) - $this->pageSize;
    }

    public function MaxPage()
    {
        return ceil($this->totalRecords / $this->pageSize);
    }

    public function allFilters()
    {
        return $this->filters;
    }
    public function filters($filter)
    {
        return (!empty($this->filters->{$filter})) ? $this->filters->{$filter} : null;
    }
    public function hasFilterValue($filter, $value)
    {
        if ($this->filters($filter) !== null) {
            if (is_array($this->filters($filter))) {
                return in_array($value, $this->filters($filter));
            } else {
                return $this->filters($filter) === $value;
            }
        }
        return false;
    }

    //

    private function ReturnHref($page)
    {
        $href = "";

        $query = "pageFilter";

        foreach ($_GET as $key => $value) {
            if ($key !== "pageNumber" && substr($key, 0, strlen($query)) !== $query) {
                $href .= ($href == "") ? "?" : "&";
                $href .= $key . "=" . $value;
            }
        }

        $href .= ($href == "") ? "?" : "&";
        $href .= "pageNumber=" . $page;

        return explode("?", $_SERVER['REQUEST_URI'], 2)[0] . $href;
    }

    public function ReturnLinkNext()
    {
        $page = $this->currentPage + 1;
        $href = $this->ReturnHref($page);

        if ($page <= $this->MaxPage())
            return "<a href='" . $href . "' class='button secondary'><span>Next</span><i class='fa-solid fa-angle-right'></i></a>";
        return "";
    }
    public function ReturnLinkLast()
    {
        $page = $this->currentPage + 1;
        $href = $this->ReturnHref($this->MaxPage());

        if ($page <= $this->MaxPage())
            return "<a href='" . $href . "' class='button secondary'><span>Last</span><i class='fa-solid fa-angles-right'></i></a>";
        return "";
    }
    public function ReturnLinkPrevious()
    {
        $page = $this->currentPage - 1;
        $href = $this->ReturnHref($page);

        if ($page > 0)
            return "<a href='" . $href . "' class='button secondary'><i class='fa-solid fa-angle-left'></i><span>Previous</span></a>";
        return "";
    }
    public function ReturnLinkFirst()
    {
        $page = $this->currentPage - 1;
        $href = $this->ReturnHref(1);

        if ($page > 0)
            return "<a href='" . $href . "' class='button secondary'><i class='fa-solid fa-angles-left'></i><span>First</span></a>";
        return "";
    }

    public function ReturnPager()
    {
        return "<div class='pager'><div class='pager-previous'>" . $this->ReturnLinkFirst() . $this->ReturnLinkPrevious() . "</div><div class='pager-count'>" . $this->currentPage . " of " . $this->MaxPage() . "</div><div class='pager-next'>" . $this->ReturnLinkNext() . $this->ReturnLinkLast() . "</div></div>";
    }
}
