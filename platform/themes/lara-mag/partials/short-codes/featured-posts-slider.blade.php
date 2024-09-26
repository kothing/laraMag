@if (count($posts) > 0)
    <section class="primary fleft">
    <div class="owl-slider owl-carousel carousel--nav inside" data-owl-auto="true" data-owl-loop="true" data-owl-speed="7000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
        @foreach($posts as $post)
            <div class="slider-item">
                <a href="{{ $post->url }}" class="slider-item-overlay">
                    <img src="{{ RvMedia::getImageUrl($post->image) }}" alt="{{ $post->name }}">
                </a>
                <header class="slider-item-header">
                    <h2 class="slider-item-title">{!! BaseHelper::clean($post->name) !!}</h2>
                    @if ($post->description)
                        <span class="slider-item-description">{{ $post->description }}</span>
                    @endif
                    <section class="featured-home-post-item-date" style="color: #fff;">
                        <span><i class="fa fa-calendar" aria-hidden="true"></i>{{ $post->created_at->translatedFormat('Y-m-d') }}</span>
                        @if (class_exists($post->author_type) && $post->author)
                            <span><i class="fa fa-user-secret" aria-hidden="true"></i>
                                {{ $post->author->name }}
                            </span>
                        @endif
                    </section>
                </header>
            </div>
        @endforeach
    </div>
    </section>
@endif
