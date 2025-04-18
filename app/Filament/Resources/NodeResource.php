<?php

namespace App\Filament\Resources;

use App\Filament\Actions\NodeInviteAction;
use App\Filament\Resources\NodeResource\Pages;
use App\Filament\Resources\NodeResource\RelationManagers;
use App\Models\Node;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
use NodeInviteAction as GlobalNodeInviteAction;

class NodeResource extends Resource
{
    protected static ?string $model = Node::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModelLabel(): string
    {
        return __('Node');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(50),
                Placeholder::make('creator')
                    ->translateLabel()
                    ->content(auth()->user()->name),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label(__('Creator')),
                TextColumn::make('consumers_count')
                    ->translateLabel()
                    ->counts('consumers'),
                TextColumn::make('providers_count')
                    ->translateLabel()
                    ->counts('providers'),
            ])
            ->filters([
                //
            ])
            ->actions([
                NodeInviteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->modifyQueryUsing(fn (Builder $query) => 
                $query
                    // Current user as Node creator
                    ->where('user_id', '=', auth()->id())
                    // Current user as Node consumer
                    ->orWhereHas('consumers', function (Builder $query) {
                        $query->where('user_id', '=', auth()->id());
                    })
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);

    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ConsumersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNodes::route('/'),
            'create' => Pages\CreateNode::route('/create'),
            'edit' => Pages\EditNode::route('/{record}/edit'),
        ];
    }

}
