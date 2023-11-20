<?php

use Tv2regionerne\StatamicReverseRelationship\Http\Controllers\ReverseRelationshipController;

Route::get('reverse-relationship', [ReverseRelationshipController::class, 'index'])->name('reverse-relationship.index');
