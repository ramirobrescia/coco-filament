<?php

namespace App\Filament\Actions;

use App\InvitationState;
use App\Mail\NodeInvitationEmail;
use App\Models\Invitation;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Mail;

class NodeInviteAction extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'invite';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Invitar');

        $this->form([
            Repeater::make('consumers')
                ->label('Consumidores')
                ->schema([
                    Grid::make()
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nombre')
                                ->alpha()
                                ->maxLength(50)
                                ->required(),
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                        ])
                ])
        ]);

        $this->action(function (array $data, Action $action) {
            $node = $action->record;

            $invitation = Invitation::create([
                'consumers' => $data['consumers'],
                'node_id' => $node->id,
                'user_id' => auth()->id(),
            ]);

            // Create emails
            $emails = [];
            foreach ($invitation->consumers as $consumer) {
                $email = new NodeInvitationEmail($invitation, $consumer);

                array_push($emails, $email);
            }

            // Send invite
            foreach ($emails as $email) {
                $sendedEmail = Mail::send($email);

                if ($sendedEmail)
                    $invitation->state = InvitationState::SENDED;
                else
                    $invitation->state = InvitationState::ERROR;

                $invitation->save();
            }
        });

        // $this->action(function (): void {
        //     $this->process(function (array $data, Model $record, Table $table) {
        //         $relationship = $table->getRelationship();

        //         $translatableContentDriver = $table->makeTranslatableContentDriver();

        //         if ($relationship instanceof BelongsToMany) {
        //             $pivot = $record->{$relationship->getPivotAccessor()};

        //             $pivotColumns = $relationship->getPivotColumns();
        //             $pivotData = Arr::only($data, $pivotColumns);

        //             if (count($pivotColumns)) {
        //                 if ($translatableContentDriver) {
        //                     $translatableContentDriver->updateRecord($pivot, $pivotData);
        //                 } else {
        //                     $pivot->update($pivotData);
        //                 }
        //             }

        //             $data = Arr::except($data, $pivotColumns);
        //         }

        //         if ($translatableContentDriver) {
        //             $translatableContentDriver->updateRecord($record, $data);
        //         } else {
        //             $record->update($data);
        //         }
        //     });

        //     $this->success();
        // });
    }
}
