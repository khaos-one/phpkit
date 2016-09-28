<?php

/**
 * Site URL routing module.
 *
 * @author Egor 'khaos' Zelensky <i@khaos.su>
 * @package phpkit
 */

if (!defined('EXEC')) { http_response_code(403); die('No direct script access is allowed;'); }

require_once('input.php');
require_once('output.php');
require_once('log.php');
require_once('string_helper.php');
require_once('web_exception.php');

class Router {
    public $Controllers_Directory = './controllers';
    public $Controller_Name = 'Default';
    public $Controller_Method = 'Default';
    public $Names_Transform = null;

    public $Controller = null;

    public function __construct() {
        //$this->Names_Transform = self::Default_Names_Transform;
    }

    public function Invoke_Hard_Controller_Mapping(array $map) {
        $pathinfo = Input::Get('path');

        // Controlled context starts here.
        try {
            if (!empty($pathinfo)) {
                $found = false;

                foreach ($map as $route => $mapping) {
                    if (String_Helper::Starts_With($pathinfo, $route)) {
                        $this->Controller_Name = $mapping[0];
                        $this->Controller_Method = $mapping[1];
                        $found = true;
                    }
                }

                if (!$found) {
                    throw new Web_Exception("Not Found", 404);
                }
            }

            $this->Internal_Invoke();
        }
        catch (Web_Exception $e) {
            $out = Output::Instance();
            $out->Response_Code($e->Code());
            $out->Content($e->Message());
            $out->Flush();
        }
    }

    public function Invoke_Default() {
        $pathinfo = Input::Get('path');

        try {
            if (!empty($pathinfo)) {
                $pathinfo = String_Helper::Split_Trim($pathinfo, '/');

                if (count($pathinfo) > 0) {
                    // Not yet supported.
                    //$this->Controller_Name = $this->Names_Transform($pathinfo[0]);
                    $this->Controller_Name = self::Default_Names_Transform($pathinfo[0]);
                }

                if (count($pathinfo) > 1) {
                    // Not yet supported.
                    //$this->Controller_Method = $this->Names_Transform($pathinfo[1]);
                    $this->Controller_Method = self::Default_Names_Transform($pathinfo[1]);
                }
            }

            $this->Internal_Invoke();
        }
        catch (Web_Exception $e) {
            $out = Output::Instance();
            $out->Response_Code($e->Code());
            $out->Content($e->Message());
            $out->Flush();
        }
    }

    private function Internal_Invoke() {
        $controller_file = $this->Controllers_Directory . DIRECTORY_SEPARATOR . strtolower($this->Controller_Name) . '.php';

        if (!is_readable($controller_file)) {
            // We should not report missing routings.
            //Log::Entry_Message(Log::ERROR, 'Controller file `%s` not found or not readable!', $controller_file);
            throw new Web_Exception("Not Found", 404);
        }
        else {
            require_once($controller_file);

            $actual_name = $this->Controller_Name . '_Controller';

            if (!class_exists($actual_name)) {
                throw new Web_Exception("Not Found", 404);
            }
            else {
                try {
                    $this->Controller = new $actual_name;

                    if (!method_exists($this->Controller, $this->Controller_Method)) {
                        throw new Web_Exception("Not Found", 404);
                    }
                    else {
                        $this->Controller->{$this->Controller_Method}();
                        $out = Output::Instance();
                        $out->Flush();
                    }
                }
                catch (Exception $e) {
                    Log::Entry_Exception(Log::Error, $e);
                    Output::Response_Code_And_Exit(404);
                }
            }
        }
    }

    public static function Default_Names_Transform(string $name) : string {
        $split = String_Helper::Split_Trim($name, '-');
        return implode(array_map(function ($w) { return ucfirst($w); }, $split));
    }
}
