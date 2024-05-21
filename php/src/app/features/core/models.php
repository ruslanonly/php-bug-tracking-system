<?php
  class User {
    function __construct(
      public int $id,
      public string $name,
      public string $password,
    ) {}
  }