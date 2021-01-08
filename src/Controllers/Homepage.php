<?php declare(strict_types = 1);

namespace Example\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Homepage
{
  private $request;
  private $response;

  public function __construct(Request $request, Response $response)
  {
      $this->request = $request;
      $this->response = $response;
  }

    public function show()
    {
        $name = $_GET['name'] ?? 'stranger';
        $content = "<h1>Hello {$name}</h1>";
        $this->response->setContent($content);
        $this->response->send();
    }
}