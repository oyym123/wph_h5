<?php
/**
 * Created by PhpStorm.
 * User: Alienware
 * Date: 2019/10/6
 * Time: 18:54
 */

namespace App\Api\Controllers;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverOptions;

class WebDriverController
{

    public function index()
    {

// Selemium服务器
        $host = 'http://localhost:4444/wd/hub'; // this is the default
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        $key = 'clothes';

        $driver->get("http://mojeek.com");


        //$driver->get("site:www.amazon.com currently unavailable " . $key);


//// 进入iframe
//        $driver->switchTo()->frame('aa');
//// 进入登录表单iframe
//        $driver->switchTo()->frame('userLoginWindow_frame');
//// 用户名
//        $driver->findElement(WebDriverBy::id("ext-comp-1005"))->sendKeys("root");
//// 密码
//        $driver->findElement(WebDriverBy::id("ext-comp-1008"))->sendKeys("123456");
//// 点击登录
//        $driver->findElement(WebDriverBy::id('ext-gen9'))->click();
//// 获取cookie
//        $cookie = $driver->manage()->getCookies();
//        print_r($cookie);
    }
}