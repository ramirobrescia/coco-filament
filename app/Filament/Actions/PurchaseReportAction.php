<?php

namespace App\Filament\Actions;

use App\Models\Purchase;
use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;

class PurchaseReportAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'purchase report';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('purchase.report.provider.action.label'));
        
        $this->icon('heroicon-o-document-text');

        $this->url(fn (Purchase $record) => route('report.purchase', ['id' => $record->id], true));
    }
}
