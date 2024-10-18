<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Filament\Post;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    use Translatable;

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 6,
                    'lg' => 12,
                ])
                    ->schema([
                        Grid::make()
                            ->schema(
                                [
                                    Section::make('Post Information')
                                        ->description('Enter the post details')
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('Title')
                                                ->afterStateUpdated( function(Forms\Get $get, Forms\Set $set){
                                                    if($get('type') !== 'open-source'){
                                                        $set('slug', Str::slug($get('title')));
                                                    }
                                                })
                                                ->lazy()
                                                ->required(),
                                            TextInput::make('slug')
                                                ->label('Slug')
                                                ->required()
                                                ->maxLength(255),
                                            MarkdownEditor::make('content')
                                                ->label('Content')
                                                ->toolbarButtons([
                                                    'attachFiles',
                                                    'blockquote',
                                                    'bold',
                                                    'bulletList',
                                                    'codeBlock',
                                                    'heading',
                                                    'italic',
                                                    'link',
                                                    'orderedList',
                                                    'redo',
                                                    'strike',
                                                    'table',
                                                    'undo',
                                                ])
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(2),
                                    Section::make('SEO')
                                        ->description('Enter the SEO details')
                                        ->schema([
                                            TextInput::make('seo_description')
                                                ->label('Description'),
                                            Textarea::make('seo_keywords')->autosize()
                                                ->label('Keywords')
                                                ->helperText('Separate keywords with commas'),
                                        ])
                                ]
                            )
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 4,
                                'lg' => 8,
                            ]),
                        Grid::make()
                            ->schema([
                                Section::make('Status')
                                    ->description('Post status')
                                    ->schema([
                                        Toggle::make('is_published')
                                            ->label('Published')
                                            ->default(false)
                                            ->required(),
                                    ]),
                                Section::make('Images')
                                    ->description('Upload images')
                                    ->schema([
                                        FileUpload::make('banner_filename')
                                            ->disk('public')
                                            ->directory('posts/banners')
                                            ->maxSize(5000)
                                            ->label('Banner Image')
                                            ->required(),
                                        FileUpload::make('cover_filename')
                                            ->disk('public')
                                            ->directory('posts/cover')
                                            ->image()
                                            ->label('Cover Image')
                                            ->maxSize(5000)
                                            ->required(),
                                    ]),
                            ])
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 4,
                            ]),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('banner_filename')
                    ->label('Banner')
                    ->square()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->description(fn(Post $post)=> Str::of($post->seo_description)->limit(50))
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_published')
                    ->toggleable()
                    ->sortable()
                    ->label('Published'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->description(fn(Post $post)=> $post->created_at->diffForHumans())
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->description(fn(Post $post)=> $post->updated_at?->diffForHumans())
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'fr'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
