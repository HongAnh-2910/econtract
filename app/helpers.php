<?php

if (!function_exists('get_file_thumb')) {
    function get_file_thumb($filename)
    {
        return route('web.files.getImageFromStorage', ['filename' => $filename]);
    }
}

if (!function_exists('get_extension_thumb')) {
    function get_extension_thumb($type)
    {
        switch ($type) {
            case 'png':
            case 'jpg':
                return asset('images/svg/image_thumb.svg');
            case 'doc':
            case 'docx':
                return asset('images/svg/word.svg');
            case 'pdf':
                return asset('images/svg/pdf.svg');
            case 'xls':
            case 'xlsx':
                return asset('images/svg/excel.svg');
            default:
                return asset('images/svg/file.svg');
        }
    }
}

if (!function_exists('check_is_image')) {
    function check_is_image($type)
    {
        switch ($type) {
            case 'jpg':
            case 'png':
            case 'jpeg':
            case 'PNG':
                return true;
            default:
                return false;
        }
    }
}

if (!function_exists('check_is_pdf')) {
    function check_is_pdf($type)
    {
        return $type == 'pdf';
    }
}

if (!function_exists('data_tree')) {
    function data_tree($data, $id, $level = 0)
    {
        $result = array();
        foreach ($data as $item) {
            if ($item->parent_id == $id) {
                $item['level'] = $level;
                $result[] = $item;
                $child = data_tree($data, $item->id, $level + 1);
                $result = array_merge($result, $child);
            }
            unset($item);
        }

        return $result;
    }
}
