<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreFooterRequest;
use App\Models\Footer;
use Symfony\Component\HttpFoundation\Request;


class LayoutHomepageFooterController extends Controller
{

    public function index(Request $request)
    {
        $footer = Footer::first();
        return view('layoutfront.homepage.footer.index', compact('footer'));

    }

    public function create()
    {
        return view('layoutfront.homepage.footer.create');

    }

    public function store(StoreFooterRequest $request)
    {
        $footer = Footer::first();
        if ($footer) {
            $footer->update($request->validated());
        } else {
            Footer::create($request->validated());
        }
        return redirect()
            ->route('footer.index')
            ->with([
                'message' => ['تم اضافة المحتويس بنجاح', 'success']
            ]);
    }
    public function edit(Footer $footer)
    {

        return view('layoutfront.homepage.footer.edit', compact('footer'));

    }

    public function update(StoreFooterRequest $request, Footer $footer)
    {
        $footer->update($request->validated());
        return redirect()
            ->route('footer.index')
            ->with(['message' => ['تم تحديث الفوتر بنجاح', 'success']]);


    }
    public function destroy(Footer $footer)
    {
        $footer->delete();
        return redirect()
            ->route('footer.index')
            ->with(['message' => ['تم حذف الفوتر بنجاح', 'success']]);

    }
}