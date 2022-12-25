<?php


namespace App\Http\Controllers\Voyager;


use Illuminate\Support\Arr;
use TCG\Voyager\Http\Controllers\ContentTypes\File;

class MyFile extends File
{

    public function handle()
    {
        if (!$this->request->hasFile($this->row->field)) {
            return;
        }

        $files = Arr::wrap($this->request->file($this->row->field));

        $filesPath = [];
        $path = $this->generatePath();

        foreach ($files as $file) {

            $filename = $this->generateFileName($file, $path);
            $file->storeAs(
                $path,
                $filename.'.'.$file->getClientOriginalExtension(),
                config('voyager.storage.disk', 'public')
            );

            array_push($filesPath, [
                'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
                'original_name' => $file->getClientOriginalName(),
                'extension' =>$file->getClientOriginalExtension(),
                'unique_id' =>uniqid(),
            ]);
        }

        return json_encode($filesPath);
    }
}
