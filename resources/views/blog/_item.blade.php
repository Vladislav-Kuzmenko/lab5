<article class="card h-100 shadow-sm border-0">
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-primary">
                {{ $blog->category?->category_name ?? 'Без категорії' }}
            </span>
            <small class="text-muted">{{ $blog->dt_created->format('d.m.Y') }}</small>
        </div>
        <h5 class="card-title">
            <a href="{{ route('blog.show', [$blog, 'lang' => $lang]) }}" class="text-decoration-none text-dark">
                {{ $blog->getTranslatedAttribute('title', $lang) }}
            </a>
        </h5>
        <p class="card-text text-secondary flex-grow-1">
            {{ \Illuminate\Support\Str::limit($blog->getTranslatedAttribute('description', $lang), 120) }}
        </p>
        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
            <small class="text-muted">Автор: {{ $blog->author?->name ?? 'Редакція' }}</small>
            <a href="{{ route('blog.show', [$blog, 'lang' => $lang]) }}" class="btn btn-sm btn-outline-primary">Читати далі →</a>
        </div>
    </div>
</article>
