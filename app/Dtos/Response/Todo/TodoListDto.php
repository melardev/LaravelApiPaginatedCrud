<?php


namespace App\Dtos\Response\Todo;


use App\Dtos\Response\Shared\PageMetaDto;
use App\Dtos\Response\Shared\SuccessResponse;

class TodoListDto
{
    public static function build($todos, $base_path = '/products')
    {
        $pageMeta = PageMetaDto::build($todos, $base_path);
        $todoDtos = [];
        foreach ($todos->items() as $key => $product) {
            $todoDtos[] = TodoDto::build($product);
        }

        return array_merge(SuccessResponse::build(), [
            'page_meta' => $pageMeta,
            'todos' => $todoDtos
        ]);
    }
}