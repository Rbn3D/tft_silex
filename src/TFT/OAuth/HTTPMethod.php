<?php

namespace TFT\OAuth;

class HTTPMethod extends SplEnum 
{
    const __default = self::GET;
    
    const GET = 0;
    const POST = 1;
}