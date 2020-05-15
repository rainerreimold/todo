<?php

function addiere() {
	global $rpc_host;
	global $rpc_uri;
	return xu_rpc_http(__FUNCTION__, func_get_args(), $rpc_host, $rpc_uri);
}

function zeit() {
	global $rpc_host;
	global $rpc_uri;
	return xu_rpc_http(__FUNCTION__, func_get_args(), $rpc_host, $rpc_uri);
}

function willkommen() {
	global $rpc_host;
	global $rpc_uri;
	return xu_rpc_http(__FUNCTION__, func_get_args(), $rpc_host, $rpc_uri);
}

function zeigeAlleFilme() {
	global $rpc_host;
	global $rpc_uri;
	return xu_rpc_http(__FUNCTION__, func_get_args(), $rpc_host, $rpc_uri);
}
