<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PostResource extends Resource
{
	protected static ?string $model = Post::class;

	protected static ?string $slug = 'posts';

	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Placeholder::make('created_at')
					->label('Created Date')
					->content(fn(?Post $record): string => $record?->created_at?->diffForHumans() ?? '-'),

				Placeholder::make('updated_at')
					->label('Last Modified Date')
					->content(fn(?Post $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

				TextInput::make('title')
					->required(),

				Select::make('team_id')
					->relationship('team', 'name')
					->searchable()
					->required(),
			]);
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				TextColumn::make('title')
					->searchable()
					->sortable(),

				TextColumn::make('team.name')
					->searchable()
					->sortable(),
			])
			->filters([
				//
			])
			->actions([
				EditAction::make(),
				DeleteAction::make(),
			])
			->bulkActions([
				BulkActionGroup::make([
					DeleteBulkAction::make(),
				]),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListPosts::route('/'),
			'create' => Pages\CreatePost::route('/create'),
			'edit' => Pages\EditPost::route('/{record}/edit'),
		];
	}

	public static function getGlobalSearchEloquentQuery(): Builder
	{
		return parent::getGlobalSearchEloquentQuery()->with(['team']);
	}

	public static function getGloballySearchableAttributes(): array
	{
		return ['title', 'team.name'];
	}

	public static function getGlobalSearchResultDetails(Model $record): array
	{
		$details = [];

		if ($record->team) {
			$details['Team'] = $record->team->name;
		}

		return $details;
	}
}
