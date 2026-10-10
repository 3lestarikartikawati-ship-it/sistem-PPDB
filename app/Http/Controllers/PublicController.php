<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Setting;
use App\Models\Faq;

class PublicController extends Controller
{
    public function index()
    {
        $content = Content::where('type', 'home_hero')->first();
        $about = Content::where('type', 'home_about')->first();
        $settings = Setting::pluck('value', 'key');
        $faqs = Faq::orderBy('order')->get();
        return view('public.beranda', compact('content', 'about', 'settings', 'faqs'));
    }

    public function profil()
    {
        $content = Content::where('type', 'profil')->first();
        return view('public.profil', compact('content'));
    }

    public function kegiatan()
    {
        $header = Content::where('type', 'kegiatan_header')->first();
        $kegiatans = Content::where('type', 'kegiatan')->where('is_active', true)->latest()->get();
        $extras = Content::where('type', 'ekstrakurikuler')->where('is_active', true)->latest()->get();
        return view('public.kegiatan', compact('header', 'kegiatans', 'extras'));
    }

    public function prestasi()
    {
        $header = Content::where('type', 'prestasi_header')->first();
        $prestasis = Content::where('type', 'prestasi')->where('is_active', true)->latest()->get();
        return view('public.prestasi', compact('header', 'prestasis'));
    }

    public function berita()
    {
        $header = Content::where('type', 'berita_header')->first();
        $beritas = Content::where('type', 'berita')->where('is_active', true)->latest()->get();
        return view('public.berita', compact('header', 'beritas'));
    }

    public function informasi()
    {
        $content = Content::where('type', 'informasi')->first();
        $settings = Setting::pluck('value', 'key');
        return view('public.informasi', compact('content', 'settings'));
    }
}
