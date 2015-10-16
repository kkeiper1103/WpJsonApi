<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/16/2015
 * Time: 8:38 AM
 */

namespace WpJsonApi\Http\Controllers;


interface RestfulInterface
{
    public function index();
    public function store();
    public function show($id);
    public function update($id);
    public function destroy($id);
}