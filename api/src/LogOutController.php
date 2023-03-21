<?php


class MallController
{
    public function __construct(private MallGateway $gateway)
    {
    }

    public function process_request(string $method)
    {
    }
}