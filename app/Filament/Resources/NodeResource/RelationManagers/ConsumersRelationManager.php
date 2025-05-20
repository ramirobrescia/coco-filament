<?php

namespace App\Filament\Resources\NodeResource\RelationManagers;

use App\Filament\Actions\NodeInviteAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ConsumersRelationManager extends RelationManager
{
    protected static string $relationship = 'consumers';

    protected static ?string $title = 'Consumidores';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('name', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Agregar')
                    ->multiple()
                    ->recordTitle(fn ($record) => "{$record->name} <br> ({$record->email})")
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'email'])
                    ->recordSelectOptionsQuery(function (Builder $query){
                        $relatedIds = $this->ownerRecord->consumers->pluck('id');
                        return $query->whereNotIn('users.id', $relatedIds);
                    })
                    ->recordSelect(fn (Select $select) => $select->allowHtml()),
                NodeInviteAction::make()->button(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->label('Quitar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
