<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Question\QuestionRepository;
use App\Repositories\Question\QuestionRepositoryInterFace;
use App\Repositories\Question_Answer\QuestionAnswerRepositoryInterFace;
use App\Repositories\Question_Answer\QuestionAnswerRepository;
use App\Repositories\Suggestion\SuggestionRepository;
use App\Repositories\Suggestion\SuggestionRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(UserRepositoryInterface::class, UserRepository::class);
        App::bind(SubjectRepository::class);
        App::bind(QuestionRepositoryInterFace::class, QuestionRepository::class);
        App::bind(QuestionAnswerRepositoryInterFace::class, QuestionAnswerRepository::class);
        App::bind(SuggestionRepositoryInterface::class, SuggestionRepository::class);
    }
}
