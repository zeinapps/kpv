<?php
namespace App\Http\Middleware;


use Closure;
use League\OAuth2\Server\Exception\InvalidScopeException;
use LucaDegasperi\OAuth2Server\Authorizer;
use Illuminate\Support\Facades\Auth;

/**
 * This is the oauth middleware class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class AuthOAuthMiddleware
{
    /**
     * The Authorizer instance.
     *
     * @var \LucaDegasperi\OAuth2Server\Authorizer
     */
    protected $authorizer;

    /**
     * Whether or not to check the http headers only for an access token.
     *
     * @var bool
     */
    protected $httpHeadersOnly = false;

    /**
     * Create a new oauth middleware instance.
     *
     * @param \LucaDegasperi\OAuth2Server\Authorizer $authorizer
     * @param bool $httpHeadersOnly
     */
    public function __construct(Authorizer $authorizer, $httpHeadersOnly = false)
    {
        $this->authorizer = $authorizer;
        $this->httpHeadersOnly = $httpHeadersOnly;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $scopesString
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $scopesString = null, $guard = null)
    {
        $access_token = $request->access_token? $request->access_token : (
                $request->header('access_token')?$request->header('access_token'):(
                $request->header('authorization')?$request->header('authorization'):false));
        
        global $userlogin_id, $token_access;
        
            $scopes = [];

            if (!is_null($scopesString)) {
                $scopes = explode('+', $scopesString);
            }

            $this->authorizer->setRequest($request);

            $this->authorizer->validateAccessToken($this->httpHeadersOnly);
            $this->validateScopes($scopes);
            
            $userlogin_id = $this->authorizer->getResourceOwnerId();
            $token_access = $access_token;

        return $next($request);
    }

    /**
     * Validate the scopes.
     *
     * @param $scopes
     *
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     */
    public function validateScopes($scopes)
    {
        if (!empty($scopes) && !$this->authorizer->hasScope($scopes)) {
            throw new InvalidScopeException(implode(',', $scopes));
        }
    }
}
