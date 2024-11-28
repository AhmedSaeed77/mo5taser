<?php

namespace App\Providers;

use App\Models\Join;
use App\Models\News;
use App\Models\Team;
use App\Models\About;
use App\Models\User;
use App\Models\Info;
use App\Models\Admin;
use App\Models\Image;
use App\Models\Course;
use App\Models\Slider;
use App\Models\Content;
use App\Models\Category;
use App\Models\Question;
use App\Models\Subscribe;
use App\Models\Testimonail;
use App\Models\Assemble;
use App\Observers\JoinObserver;
use App\Observers\AssembleObserver;
use App\Observers\NewsObserver;
use App\Observers\TeamObserver;
use App\Observers\UserObserver;
use App\Observers\AboutObserver;
use App\Observers\AdminObserver;
use App\Observers\ImageObserver;
use App\Observers\CourseObserver;
use App\Observers\SliderObserver;
use App\Observers\ContentObserver;
use App\Observers\CategoryObserver;
use App\Observers\QuestionObserver;
use App\Observers\SubscribeObserver;
use App\Observers\TestimonailObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\WhyRepository;
use App\Repository\WhyRepositoryInterface;
use App\Repository\BankRepositoryInterface;
use App\Repository\CartRepositoryInterface;
use App\Repository\Eloquent\BankRepository;
use App\Repository\Eloquent\CartRepository;
use App\Repository\Eloquent\InfoRepository;
use App\Repository\Eloquent\JoinRepository;
use App\Repository\Eloquent\NewsRepository;
use App\Repository\Eloquent\SpecRepository;
use App\Repository\Eloquent\TeamRepository;
use App\Repository\Eloquent\TermRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\JoinRepositoryInterface;
use App\Repository\NewsRepositoryInterface;
use App\Repository\SpecRepositoryInterface;
use App\Repository\TeamRepositoryInterface;
use App\Repository\TermRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\AboutRepositoryInterface;
use App\Repository\AdminRepositoryInterface;
use App\Repository\Eloquent\AboutRepository;
use App\Repository\Eloquent\AdminRepository;
use App\Repository\Eloquent\ImageRepository;
use App\Repository\ImageRepositoryInterface;
use App\Repository\CouponRepositoryInterface;
use App\Repository\CourseRepositoryInterface;
use App\Repository\Eloquent\CouponRepository;
use App\Repository\Eloquent\CourseRepository;
use App\Repository\Eloquent\RatingRepository;
use App\Repository\Eloquent\SliderRepository;
use App\Repository\RatingRepositoryInterface;
use App\Repository\SliderRepositoryInterface;
use App\Repository\ContactRepositoryInterface;
use App\Repository\ContentRepositoryInterface;
use App\Repository\Eloquent\ContactRepository;
use App\Repository\Eloquent\ContentRepository;
use App\Repository\Eloquent\PrivacyRepository;
use App\Repository\Eloquent\SubjectRepository;
use App\Repository\PrivacyRepositoryInterface;
use App\Repository\SubjectRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ExchangeRepository;
use App\Repository\Eloquent\PassExamRepository;
use App\Repository\Eloquent\QuestionRepository;
use App\Repository\ExchangeRepositoryInterface;
use App\Repository\PassExamRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\Eloquent\SubscribeRepository;
use App\Repository\SubscribeRepositoryInterface;
use App\Repository\Eloquent\StudentExamRepository;
use App\Repository\Eloquent\TestimonailRepository;
use App\Repository\StudentExamRepositoryInterface;
use App\Repository\TestimonailRepositoryInterface;
use App\Repository\Eloquent\StudentAnswerRepository;
use App\Repository\Eloquent\StudentResultRepository;
use App\Repository\StudentAnswerRepositoryInterface;
use App\Repository\StudentResultRepositoryInterface;
use App\Repository\ContentCommentRepositoryInterface;
use App\Repository\Eloquent\ContentCommentRepository;
use App\Repository\Eloquent\QuestionAnswerRepository;
use App\Repository\QuestionAnswerRepositoryInterface;
use App\Repository\ContentCategoryRepositoryInterface;
use App\Repository\Eloquent\ContentCategoryRepository;
use App\Repository\Eloquent\SplitExamAttemptRepository;
use App\Repository\SplitExamAttemptRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(AboutRepositoryInterface::class, AboutRepository::class);
        $this->app->singleton(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->singleton(InfoRepositoryInterface::class, InfoRepository::class);
        $this->app->singleton(SliderRepositoryInterface::class, SliderRepository::class);
        $this->app->singleton(WhyRepositoryInterface::class, WhyRepository::class);
        $this->app->singleton(TestimonailRepositoryInterface::class, TestimonailRepository::class);
        $this->app->singleton(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->singleton(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->singleton(PrivacyRepositoryInterface::class, PrivacyRepository::class);
        $this->app->singleton(TermRepositoryInterface::class, TermRepository::class);
        $this->app->singleton(PassExamRepositoryInterface::class, PassExamRepository::class);
        $this->app->singleton(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->singleton(StudentExamRepositoryInterface::class, StudentExamRepository::class);
        $this->app->singleton(StudentAnswerRepositoryInterface::class, StudentAnswerRepository::class);
        $this->app->singleton(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->singleton(QuestionAnswerRepositoryInterface::class, QuestionAnswerRepository::class);
        $this->app->singleton(ContentRepositoryInterface::class, ContentRepository::class);
        $this->app->singleton(StudentResultRepositoryInterface::class, StudentResultRepository::class);
        $this->app->singleton(RatingRepositoryInterface::class, RatingRepository::class);
        $this->app->singleton(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->singleton(SubscribeRepositoryInterface::class, SubscribeRepository::class);
        $this->app->singleton(BankRepositoryInterface::class, BankRepository::class);
        $this->app->singleton(CartRepositoryInterface::class, CartRepository::class);
        $this->app->singleton(ContentCommentRepositoryInterface::class, ContentCommentRepository::class);
        $this->app->singleton(ContentCategoryRepositoryInterface::class, ContentCategoryRepository::class);
        $this->app->singleton(ImageRepositoryInterface::class, ImageRepository::class);
        $this->app->singleton(JoinRepositoryInterface::class, JoinRepository::class);
        $this->app->singleton(SpecRepositoryInterface::class, SpecRepository::class);
        $this->app->singleton(ExchangeRepositoryInterface::class,ExchangeRepository::class);
        $this->app->singleton(SplitExamAttemptRepositoryInterface::class,SplitExamAttemptRepository::class);
    }

    public function boot()
    {

        \View::share('image_control', Image::first());
        \View::share('info', Info::first());

        Schema::defaultStringLength(191);
//        date_default_timezone_set('Africa/Cairo');
        About::observe(AboutObserver::class);
        Team::observe(TeamObserver::class);
        Slider::observe(SliderObserver::class);
        Testimonail::observe(TestimonailObserver::class);
        News::observe(NewsObserver::class);
        Category::observe(CategoryObserver::class);
        User::observe(UserObserver::class);
        Admin::observe(AdminObserver::class);
        Question::observe(QuestionObserver::class);
        Course::observe(CourseObserver::class);
        Content::observe(ContentObserver::class);
        Image::observe(ImageObserver::class);
        Join::observe(JoinObserver::class);
        Assemble::observe(AssembleObserver::class);
        // Subscribe::observe(SubscribeObserver::class);
    }
}
