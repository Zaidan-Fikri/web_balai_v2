<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreProfilePageRequest;
use App\Http\Requests\Admin\UpdateProfilePageRequest;
use App\Models\ProfilePage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProfilePageController extends Controller
{
    public function index(): View
    {
        $profilePages = ProfilePage::query()
            ->where('slug', '!=', 'informasi-pejabat')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('pages.admin.profile_pages.index', compact('profilePages'));
    }

    public function edit(ProfilePage $profilePage): View
    {
        abort_if($profilePage->slug === 'informasi-pejabat', 404);

        return view('pages.admin.profile_pages.edit', compact('profilePage'));
    }

    public function store(StoreProfilePageRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 99;

        ProfilePage::create($data);

        return redirect()
            ->route('admin.profile-pages.index')
            ->with('success', 'Halaman profil berhasil ditambahkan.');
    }

    public function update(UpdateProfilePageRequest $request, ProfilePage $profilePage): RedirectResponse
    {
        abort_if($profilePage->slug === 'informasi-pejabat', 404);

        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], $profilePage->id);
        $data['sort_order'] = $data['sort_order'] ?? $profilePage->sort_order;

        $profilePage->update($data);

        return redirect()
            ->route('admin.profile-pages.edit', $profilePage)
            ->with('success', 'Halaman profil berhasil diperbarui.');
    }

    public function destroy(ProfilePage $profilePage): RedirectResponse
    {
        abort_if($profilePage->slug === 'informasi-pejabat', 404);

        if ($profilePage->isDefaultPage()) {
            return redirect()
                ->route('admin.profile-pages.index')
                ->with('success', 'Halaman profil utama tidak dapat dihapus.');
        }

        $profilePage->delete();

        return redirect()
            ->route('admin.profile-pages.index')
            ->with('success', 'Halaman profil berhasil dihapus.');
    }

    public function uploadOrgPhoto(Request $request): JsonResponse
    {
        $request->validate(['photo' => 'required|image|max:10240']);
        $path = $request->file('photo')->store('org-photos', 'public');
        return response()->json(['url' => Storage::url($path)]);
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value) ?: 'halaman-profil';
        $slug = $baseSlug;
        $index = 2;

        while (
            ProfilePage::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $index;
            $index++;
        }

        return $slug;
    }
}
