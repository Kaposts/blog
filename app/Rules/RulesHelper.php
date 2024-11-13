<?php

namespace App\Rules;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class RulesHelper
{
  public const REQUIRED = 'required';
  public const NULLABLE = 'nullable';
  public const EXISTS = 'exists';
  public const STRING = 'string';
  public const INT = 'int';
  public const ARRAY = 'array';
  public const BOOLEAN = 'boolean';
  public const INTEGER = 'integer';
  public const UNIQUE = 'unique';

  public static function existsOnDatabase(string $table, string $column = "id"): Exists
  {
      return Rule::exists($table, $column);
  }
}
