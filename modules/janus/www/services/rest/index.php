<?php
$request = sspmod_janus_REST_Utils::processRequest($_GET);

if (is_object($request)) {
    \Lvl\Profiler::getInstance()->startBlock('Call Rest');
    $result = sspmod_janus_REST_Utils::callMethod($request);
    \Lvl\Profiler::getInstance()->startBlock('Send Response');
    sspmod_janus_REST_Utils::sendResponse($result['status'], $result['data'], 'application/json');
    \Lvl\Profiler::getInstance()->endBlock();
} else {
    throw new Exception('Could not process Janus REST request');
}