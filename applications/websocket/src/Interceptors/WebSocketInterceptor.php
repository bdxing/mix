<?php

namespace WebSocket\Interceptors;

use Mix\Http\Message\Request;
use Mix\Http\Message\Response;
use Mix\WebSocket\Interceptor\WebSocketInterceptorInterface;
use Mix\WebSocket\Support\WebSocketHandshakeInterceptor;

/**
 * Class WebSocketInterceptor
 * @package WebSocket\Interceptors
 * @author liu,jian <coder.keda@gmail.com>
 */
class WebSocketInterceptor extends WebSocketHandshakeInterceptor implements WebSocketInterceptorInterface
{

    /**
     * 握手
     * @param Request $request
     * @param Response $response
     */
    public function handshake(Request $request, Response $response)
    {
        // TODO: Implement handshake() method.
        // 自定义握手处理
        $uid  = app()->session->get('uid');
        $name = app()->session->get('name');
        if (empty($uid) || empty($name)) {
            $response->statusCode = 500;
            $response->send();
            return;
        }

        // 使用tcpSession保存会话信息
        app()->tcpSession->set('uid', $uid);
        app()->tcpSession->set('name', $name);

        // 默认握手处理
        parent::handshake($request, $response);
    }

}
