<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class PdfButton extends AbstractTool
{
    
    public function render()
    {
        
        return $this->renderexportPdf();
    }

    protected function getexportpdfPath()
    {   $url=Request::url();
        return $url.'/exportpdf';
    }
    protected function renderexportPdf()
    {   $class = uniqid();
        $script = <<<SCRIPT

        $('.{$class}-exportpdf').unbind('click').click(function() {
            location.href='{$this->getexportpdfPath()}';
            return false;
        });
SCRIPT;
        Admin::script($script);
        $getexportpdfPath = trans('PDF Export');

        return <<<HTML
<div class="btn-group" style="margin-right: 5px">
    <a href="{$this->getexportpdfPath()}" class="btn btn-sm btn-primary {$class}-exportpdf" title="{$getexportpdfPath}">
        <i class="fa fa-file-pdf-o"></i><span class="hidden-xs"> {$getexportpdfPath}</span>
    </a>
</div>
HTML;
    }
}