<?php

namespace App\Helpers;

use App\Models\Admin\StaticBlock;

class StaticBlockHelper
{
    /**
     * Render a static block by its identifier
     *
     * @param string $identifier The unique identifier of the static block
     * @param string $default Default content to display if block not found
     * @return string The HTML content of the static block
     */
    public static function render($identifier, $default = '')
    {
        $block = StaticBlock::where('identifier', $identifier)
                            ->where('is_active', 1)
                            ->first();
        
        return $block ? $block->content : $default;
    }
}