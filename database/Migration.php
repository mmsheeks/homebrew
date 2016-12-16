<?php

namespace Homebrew\Database;

use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Database\Schema\Blueprint;

/**
 * Table Class - drives our migration system
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
abstract class Migration {
    
    protected $schema;
    
    public function __construct() {
        $this->schema = Database::schema();
    }
    
}