<?php

namespace App\Models;

use App\Utils\Traits\CommonRelations;
use App\Utils\Traits\CommonScopes;
use App\Utils\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class MessageAttachment extends Model
{
    use CommonRelations, CommonScopes, Search;

    protected $guarded = [];

    static function uploadAttachments($request, $messageID) {
        for ($i = 0; $i < $request->totalFiles; $i++) {
            if ($request->file('files')[$i]) {
                $file      = $request->file('files')[$i];
                $name = rand(0, 10000) . time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = storage_path('/app/public/chat');
                $path =  '/chat/' . $name;
                $file->move($destinationPath, $name);
                MessageAttachment::create([
                    'file' => $path,
                    'filename'  => $name,
                    'message_id' => $messageID
                ]);

            }

        }
    }
}
