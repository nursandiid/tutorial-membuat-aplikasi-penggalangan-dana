<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        $bank = Bank::all()->pluck('name', 'id');
        
        return view('setting.index', compact('setting', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $rules = [
            'owner_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|string|min:11|max:17',
            'phone_hours' => 'required',
            'about' => 'required',
            'address' => 'nullable',
            'city' => 'nullable',
            'province' => 'nullable',
            'company_name' => 'required',
            'short_description' => 'required',
            'keyword' => 'nullable'
        ];

        if ($request->has('pills') && $request->pills == 'logo') {
            $rules = [
                'path_image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'path_image_header' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'path_image_footer' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            ];
        }

        if ($request->has('pills') && $request->pills == 'sosial-media') {
            $rules = [
                'instagram_link' => 'required|url',
                'twitter_link' => 'required|url',
                'fanpage_link' => 'required|url',
                'google_plus_link' => 'required|url'
            ];
        }

        if ($request->has('pills') && $request->pills == 'bank') {
            $rules = [
                'bank_id' => 'required|exists:bank,id|unique:bank_setting,bank_id',
                'account' => 'required|unique:bank_setting,account',
                'name' => 'required',
                'is_main' => [
                    'nullable',
                    Rule::unique('bank_setting')->where(function ($query) use ($request) {
                        $countAvailable = $query->where('is_main', 1)
                            ->count();

                        if ($request['is_main'] == 1 && $countAvailable > 0) {
                            return false;
                        }

                        return true;
                    })
                ]
            ];
        }

        $this->validate($request, $rules, [
            'is_main.unique' => 'Akun utama sudah ada sebelumnya.'
        ]);

        $data = $request->except('path_image', 'path_image_header', 'path_image_footer');

        if ($request->hasFile('path_image')) {
            if (Storage::disk('public')->exists($request->path_image)) {
                Storage::disk('public')->delete($request->path_image);
            }

            $data['path_image'] = upload('setting', $request->file('path_image'), 'setting');
        }

        if ($request->hasFile('path_image_header')) {
            if (Storage::disk('public')->exists($request->path_image_header)) {
                Storage::disk('public')->delete($request->path_image_header);
            }

            $data['path_image_header'] = upload('setting', $request->file('path_image_header'), 'setting');
        }

        if ($request->hasFile('path_image_footer')) {
            if (Storage::disk('public')->exists($request->path_image_footer)) {
                Storage::disk('public')->delete($request->path_image_footer);
            }

            $data['path_image_footer'] = upload('setting', $request->file('path_image_footer'), 'setting');
        }

        $setting->update($data);

        if ($request->has('pills') && $request->pills == 'bank') {
            $setting->bank_setting()->attach($request->bank_id, $request->only('account', 'name', 'is_main'));
        }


        return back()->with([
            'message' => 'Pengaturan berhasil diperbarui',
            'success' => true
        ]);
    }

    public function bankDestroy(Setting $setting, $id)
    {
        $setting->bank_setting()->detach($id);

        return back()->with([
            'message' => 'Bank terdaftar berhasil dihapus',
            'success' => true
        ]);
    }
}
