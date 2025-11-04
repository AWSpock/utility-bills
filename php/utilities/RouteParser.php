<?php

class RouteParser
{
    protected $Route;

    protected $basePath;
    protected $siteDir;
    protected $request;
    protected $pagePath;
    protected $codePath;
    protected $resourcePath;

    public function __construct($type = "view")
    {
        $this->siteDir = $_SERVER['DOCUMENT_ROOT'];
        $this->request = $_SERVER['REDIRECT_URL'];

        switch (strtolower($type)) {
            case "view":
                $this->basePath = "/pages";
                $this->ValidateRoute();
                break;
            case "api":
                $this->basePath = "/api";
                $this->ValidateAPIRoute();
                break;
            default:
                throw new Exception("Invalid RouteParser Type");
                break;
        }
    }

    protected function ValidateRoute()
    {
        if (preg_match("~^/$~", $this->request)) {
            $this->resourcePath = "/index";
            return;
        }
        if (preg_match("~/address/create$~", $this->request)) {
            $this->resourcePath = "/address/create";
            return;
        }


        if (preg_match("~^/address/(\d+)/summary$~", $this->request)) {
            $this->resourcePath = "/address/summary";
            return;
        }
        if (preg_match("~^/address/(\d+)/edit$~", $this->request)) {
            $this->resourcePath = "/address/edit";
            return;
        }
        if (preg_match("~^/address/(\d+)/delete$~", $this->request)) {
            $this->resourcePath = "/address/delete";
            return;
        }

        /* index */
        if (preg_match("~^/address/(\d+)/bill-type$~", $this->request)) {
            $this->resourcePath = "/bill-type/index";
            return;
        }
        if (preg_match("~^/address/(\d+)/bill-type/(\d+)/bill$~", $this->request)) {
            $this->resourcePath = "/bill/index";
            return;
        }

        /* create */
        if (preg_match("~^/address/(\d+)/bill-type/create$~", $this->request)) {
            $this->resourcePath = "/bill-type/create";
            return;
        }
        if (preg_match("~^/address/(\d+)/bill-type/(\d+)/bill/create$~", $this->request)) {
            $this->resourcePath = "/bill/create";
            return;
        }

        /* edit */
        if (preg_match("~^/address/(\d+)/bill-type/(\d+)/edit$~", $this->request)) {
            $this->resourcePath = "/bill-type/edit";
            return;
        }
        if (preg_match("~^/address/(\d+)/bill-type/(\d+)/bill/(\d+)/edit$~", $this->request)) {
            $this->resourcePath = "/bill/edit";
            return;
        }

        /* delete */
        if (preg_match("~^/address/(\d+)/bill-type/(\d+)/delete$~", $this->request)) {
            $this->resourcePath = "/bill-type/delete";
            return;
        }
        if (preg_match("~^/address/(\d+)/bill-type/(\d+)/bill/(\d+)/delete$~", $this->request)) {
            $this->resourcePath = "/bill/delete";
            return;
        }


        /* basic */
        if (preg_match("~^/error$~", $this->request)) {
            $this->resourcePath = "/error";
            return;
        }
        if (preg_match("~^/unauthorized$~", $this->request)) {
            $this->resourcePath = "/unauthorized";
            return;
        }
    }

    protected function ValidateAPIRoute()
    {
        if (preg_match("~^/api/address$~", $this->request)) {
            $this->resourcePath = "/address";
            return;
        }
        if (preg_match("~^/api/address/(\d+)$~", $this->request)) {
            $this->resourcePath = "/address";
            return;
        }

        if (preg_match("~^/api/address/(\d+)/bill-type$~", $this->request)) {
            $this->resourcePath = "/bill-type";
            return;
        }
        if (preg_match("~^/api/address/(\d+)/bill-type/(\d+)$~", $this->request)) {
            $this->resourcePath = "/bill-type";
            return;
        }

        if (preg_match("~^/api/address/(\d+)/bill-type/(\d+)/bill$~", $this->request)) {
            $this->resourcePath = "/bill";
            return;
        }
        if (preg_match("~^/api/address/(\d+)/bill-type/(\d+)/bill/(\d+)$~", $this->request)) {
            $this->resourcePath = "/bill";
            return;
        }
    }

    function Request()
    {
        return $this->request;
    }
    function PagePath()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->siteDir . $this->basePath . $this->resourcePath . ".php";
    }
    function CodePath()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->siteDir . $this->basePath . $this->resourcePath . ".code.php";;
    }
    function CSS()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->basePath . $this->resourcePath . ".php.css";
    }
    function JS()
    {
        if ($this->resourcePath == "")
            return "";
        return $this->basePath . $this->resourcePath . ".php.js";
    }
    function ResourcePath()
    {
        return $this->resourcePath;
    }
    function Page404()
    {
        return $this->siteDir . $this->basePath . "/404.php";
    }
}
