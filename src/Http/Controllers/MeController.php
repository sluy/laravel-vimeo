<?php

namespace Vientodigital\LaravelVimeo\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Vientodigital\LaravelVimeo\LaravelVimeoFacade as V;

class MeController
{
    public function index()
    {
        $pagination = V::paginate();

        return view('laravel-vimeo::me.index', compact('pagination'));
    }

    public function create()
    {
        return view('laravel-vimeo::me.create');
    }

    public function store()
    {
        $data = request()->all();

        $validator = Validator::make($data, $this->getStoreRules());
        if ($validator->fails()) {
            return redirect()->route('laravel-vimeo.me.create')
                ->withErrors($validator)
                ->withInput()
            ;
        }
        $dir = sys_get_temp_dir().DIRECTORY_SEPARATOR;
        $name = uniqid();
        $path = $dir.DIRECTORY_SEPARATOR.$name;
        $data['video']->move($dir, $name);
        $config = [
            'name' => $data['name'],
            'description' => isset($data['description']) ? $data['description'] : null,
            'privacy' => [
                'view' => $data['privacy_view'],
                'download' => isset($data['privacy_download']) && ('1' === $data['privacy_download']),
                'embed' => $data['privacy_embed'],
            ],
        ];

        $videoRoute = V::getClient()->upload($path, $config);
        unlink($path);

        return redirect()->route('laravel-vimeo.me.index')->with('status', __('laravel-vimeo.words::video_saved', ['route' => $videoRoute]));
    }

    protected function getStoreRules()
    {
        return [
            'video' => 'required|mimes:mp4,mov,ogg,qt',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'privacy_view' => [
                Rule::in(['anybody', 'contacts', 'disable', 'nobody', 'unlisted']),
            ],
            'privacy_embed' => [
                Rule::in(['private', 'public']),
            ],
            'privacy_download' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
