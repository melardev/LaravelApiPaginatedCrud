<?php


namespace App\Dtos\Response\Todo;


class TodoDto
{
    public static function build($todo, $includeDetails = false)
    {
        $dto = [
            'id' => $todo->id,
            'name' => $todo->title,
            'completed' => (boolean)$todo->completed,
        ];
        if ($includeDetails)
            $dto['description'] = $todo->description;

        $dto['created_at'] = $todo->created_at;
        $dto['updated_at'] = $todo->updated_at;

        return $dto;
    }
}