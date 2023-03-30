<?php

namespace Pest\Lumen\Testing\Concerns;

trait InteractsWithSession
{
    protected function initSession() {
        $this->app->configure('session');
        $this->app->register(\Illuminate\Session\SessionServiceProvider::class);

        //setup session
        $this->app->singleton(\Illuminate\Session\SessionManager::class, function () {
            return $this->app->loadComponent('session', \Illuminate\Session\SessionServiceProvider::class, 'session');
        });

        $this->app->singleton('session.store', function () {
            return $this->app->loadComponent('session', \Illuminate\Session\SessionServiceProvider::class, 'session.store');
        });
        $this->app->middleware([
            \Illuminate\Session\Middleware\StartSession::class,
        ]);

        //session config
        $this->app['config']->set('session', [
            'driver'=>'file',
            'lifetime'=>60,
            'encrypt'=>false,
            'files' => storage_path('framework/sessions'),
            'lottery' => [2, 100],
            'cookie'=>'pest_sess',
            'path'=>'/'
        ]);
    }
    /**
     * Set the session to the given array.
     *
     * @param  array  $data
     * @return $this
     */
    public function withSession(array $data)
    {
        $this->session($data);

        return $this;
    }

    /**
     * Set the session to the given array.
     *
     * @param  array  $data
     * @return $this
     */
    public function session(array $data)
    {
        $this->startSession();

        foreach ($data as $key => $value) {
            $this->app['session']->put($key, $value);
        }

        return $this;
    }

    /**
     * Start the session for the application.
     *
     * @return $this
     */
    protected function startSession()
    {
        if (! $this->app['session']->isStarted()) {
            $this->app['session']->start();
        }

        return $this;
    }

    /**
     * Flush all of the current session data.
     *
     * @return $this
     */
    public function flushSession()
    {
        $this->startSession();

        $this->app['session']->flush();

        return $this;
    }
}
