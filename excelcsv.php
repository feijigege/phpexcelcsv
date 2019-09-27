<?php

/**
 * 表格类 class
 *
 * @Description
 * @example
 * @author 飞机哥哥
 * @since
 */
class excelcsv
{
    /**
     * @param        $arr 表格数据
     * @param        $excelfields_header 列名和列对应的表格数据 array('name'=>'名称','total'=>'下载数量')
     * @param string $titles 表格名和表格title
     * @return array
     */
    public function exceldown($arr, $excelfields_header, $titles = '表格名')
    {
        if (is_array($excelfields_header)) {
            $fields = $header = array();
            foreach ($excelfields_header as $k => $v) {
                $fields[] = $k;
                $header[] = $v;
            }
        }
        $headArr = array();
        for ($i = 0; $i < count($fields); $i++) {
            $headArr[$fields[$i]] = $header[$i];
        }
        $url = self::execltable($titles, $headArr, $arr);
        // json返回
        $returnArr = array(
            'url' => $url,
            'totalCount' => count($arr),
            'downCount' => count($arr),
        );
        return $returnArr;
    }

    /**
     *     创建excel导出表格
     */
    private static function execltable($title, $headArr, $rows, $lx = '')
    {
        if ($lx == '') {
            $lx = 'xls';
        }
        $sty  = 'style="white-space:nowrap;border:thin solid #999;font-size:12px;text-align:center;font-family:\'宋体\';"';
        $s    = '<html><head><meta charset="utf-8"><title style="font-size:16px;text-align: center;">' . $title . '</title></head><body>';
        $s    .= '<style>title{table tr td{text-align:left}</style>';
        $s    .= '<table border="0" style="border-collapse:collapse;">';
        $hlen = 1;
        $s1   = '<tr height="30"><td ' . $sty . '>序号</td>';
        foreach ($headArr as $na) {
            $hlen++;
            $s1 .= '<td ' . $sty . '>' . $na . '</td>';
        }
        $s1 .= '</tr>';
        $s  .= '<tr height="40"><td ' . $sty . ' colspan="' . $hlen . '">' . $title . '</td></tr>';
        $s  .= $s1;
        foreach ($rows as $k => $rs) {
            $s .= '<tr height="26">';
            $s .= '<td align="center" ' . $sty . '>' . ($k + 1) . '</td>';
            foreach ($headArr as $kf => $na) {
                $val = '';
                if (isset($rs[$kf])) {
                    $val = $rs[$kf];
                }

                $s .= '<td ' . $sty . '>' . $val . '</td>';
            }
            $s .= '</tr>';
        }
        $s .= '</table>';

        $s         .= '</body></html>';
        $mkdir     = 'uploadexcel/' . date('Y-m') . '';
        $mkdir_url = 'uploadexcel/' . date('Y-m') . '';
        if (!is_dir($mkdir)) {
            mkdir($mkdir);
        }
        $filename = str_replace('/', '', $title . '_' . date('YmdHis') .'_'.mt_rand(). '.' . $lx);
        $url      = $mkdir . '/' . $filename;
        $bo       = file_put_contents(iconv('utf-8', 'gb2312', $url), $s);
        return $mkdir_url . '/' . $filename;
    }
}
