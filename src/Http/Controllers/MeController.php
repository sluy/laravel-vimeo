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

        try {
            $res = V::getClient()->upload($path, [
                'name' => $data['name'],
                'privacy' => [
                    'view' => $data['access_view'],
                ],
            ]);
        } catch (\Throwable $th) {
            //tus-php mkdir error!.
        }

        return redirect()->route('laravel-vimeo.me.index')->with('status', __('laravel-vimeo.words::video_saved'));
    }

    protected function getStoreRules()
    {
        return [
            'video' => 'required|mimes:mp4,mov,ogg,qt',
            'name' => 'required|string',
            'privacy_view' => [
                Rule::in(['anybody', 'private']),
            ],
        ];
    }
}
