<?php

class demo
{
    public static function excelcsv()
    {
        try {
            include '/excelcsv.php';
            $titleArr   = array(
                'id' => 'ID',
                'name' => '姓名',
                'num' => '编号',
            );
            $contentArr = array(
                $array = array('id' => 1, 'name' => '飞机哥哥', 'num' => 666),
                $array = array('id' => 2, 'name' => 'feijigege', 'num' => 888),
            );
            $eccelcsv   = new excelcsv();
            $excelRs    = $eccelcsv->exceldown($contentArr, $titleArr, '表格');
            exit(json_encode($excelRs, JSON_UNESCAPED_UNICODE));
        } catch (Exception $e) {
            exit($e->getMessage());
        }

    }
}

demo::excelcsv();
