<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // ============ FRONTEND METHODS ============

    /**
     * แสดงรายการบทความสำหรับหน้า frontend
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tag = $request->get('tag');

        $query = Article::published()->recent();

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        // Filter by tag
        if ($tag) {
            $query->whereJsonContains('tags', $tag);
        }

        $articles = $query->paginate(12);
        $featuredArticles = Article::published()->featured()->recent()->limit(3)->get();

        // Get popular tags
        $popularTags = Article::published()
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10)
            ->keys();

        return view('blog.index', compact('articles', 'featuredArticles', 'popularTags', 'search', 'tag'));
    }

    /**
     * แสดงบทความเดี่ยว
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->published()->firstOrFail();

        // Increment views
        $article->incrementViews();

        // Related articles
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->recent()
            ->limit(3)
            ->get();

        return view('blog.show', compact('article', 'relatedArticles'));
    }

    // ============ ADMIN METHODS ============

    /**
     * แสดงรายการบทความในหลังบ้าน
     */
    public function adminIndex(Request $request)
    {
        try {
            Paginator::useBootstrap();

            $sort = $request->query('sort', 'created_desc');
            $status = $request->query('status');
            $search = $request->query('search');

            $query = Article::query();

            // Search
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%");
                });
            }

            // Filter by status
            if ($status) {
                $query->where('status', $status);
            }

            // Sorting
            switch ($sort) {
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'published_asc':
                    $query->orderBy('published_at', 'asc');
                    break;
                case 'published_desc':
                    $query->orderBy('published_at', 'desc');
                    break;
                case 'views_desc':
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }

            $articles = $query->paginate(10)->withQueryString();

            return view('admin.articles.index', compact('articles', 'sort', 'status', 'search'));

        } catch (\Exception $e) {
            \Log::error('ArticleController@adminIndex ERROR: ' . $e->getMessage());
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดรายการบทความได้');
            return back();
        }
    }

    /**
     * แสดงฟอร์มสร้างบทความใหม่
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * บันทึกบทความใหม่
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'author' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'featured' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
            'published_at' => 'nullable|date'
        ], [
            'title.required' => 'กรุณากรอกหัวข้อบทความ',
            'content.required' => 'กรุณากรอกเนื้อหาบทความ',
            'featured_image.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'featured_image.max' => 'ขนาดไฟล์ต้องไม่เกิน 5MB'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = $request->file('featured_image')
                    ->store('articles', 'public');
            }

            // Process tags
            if (!empty($data['tags'])) {
                $data['tags'] = array_map('trim', explode(',', $data['tags']));
            } else {
                $data['tags'] = null;
            }

            // Set published_at if status is published and no date provided
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            Article::create($data);

            Alert::success('สำเร็จ', 'เพิ่มบทความเรียบร้อยแล้ว');
            return redirect()->route('admin.articles.index');

        } catch (\Exception $e) {
            \Log::error('ArticleController@store ERROR: ' . $e->getMessage());
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกบทความได้');
            return back()->withInput();
        }
    }

    /**
     * แสดงฟอร์มแก้ไขบทความ
     */
    public function edit($id)
    {
        try {
            $article = Article::findOrFail($id);
            return view('admin.articles.edit', compact('article'));
        } catch (\Exception $e) {
            Alert::error('ไม่พบบทความ', 'ไม่พบบทความที่ต้องการแก้ไข');
            return redirect()->route('admin.articles.index');
        }
    }

    /**
     * อัปเดตบทความ
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'author' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'featured' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
            'published_at' => 'nullable|date'
        ], [
            'title.required' => 'กรุณากรอกหัวข้อบทความ',
            'content.required' => 'กรุณากรอกเนื้อหาบทความ',
            'featured_image.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'featured_image.max' => 'ขนาดไฟล์ต้องไม่เกิน 5MB'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $article = Article::findOrFail($id);
            $data = $validator->validated();

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete old image
                if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                    Storage::disk('public')->delete($article->featured_image);
                }

                $data['featured_image'] = $request->file('featured_image')
                    ->store('articles', 'public');
            }

            // Process tags
            if (!empty($data['tags'])) {
                $data['tags'] = array_map('trim', explode(',', $data['tags']));
            } else {
                $data['tags'] = null;
            }

            // Set published_at if status is published and no date provided
            if ($data['status'] === 'published' && empty($data['published_at']) && !$article->published_at) {
                $data['published_at'] = now();
            }

            $article->update($data);

            Alert::success('สำเร็จ', 'อัปเดตบทความเรียบร้อยแล้ว');
            return redirect()->route('admin.articles.index');

        } catch (\Exception $e) {
            \Log::error('ArticleController@update ERROR: ' . $e->getMessage());
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถอัปเดตบทความได้');
            return back()->withInput();
        }
    }

    /**
     * ลบบทความ
     */
    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);

            // Delete featured image
            if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                Storage::disk('public')->delete($article->featured_image);
            }

            $article->delete();

            Alert::success('สำเร็จ', 'ลบบทความเรียบร้อยแล้ว');
            return redirect()->route('admin.articles.index');

        } catch (\Exception $e) {
            \Log::error('ArticleController@destroy ERROR: ' . $e->getMessage());
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถลบบทความได้');
            return redirect()->route('admin.articles.index');
        }
    }
}