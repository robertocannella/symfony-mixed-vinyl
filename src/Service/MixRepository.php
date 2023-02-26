<?php

namespace App\Service;

use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository

{
    public function __construct(
        private readonly HttpClientInterface               $githubContentClient,
        private readonly CacheInterface                    $cache,

        #[Autowire('%kernel.debug')]
        private readonly bool                               $isDebug,

        #[Autowire(service: 'twig.command.debug')]
        private readonly DebugCommand                       $twigDebugCommand
    )


    {
    }

    public function findAll():array{

        // Cool tool that showcases AutoWiring
//        $output = new BufferedOutput();
//        $this->twigDebugCommand->run(new ArrayInput([]), $output);
//        dd($output);



        /* If a cached version exists, use it. Otherwise make a new HTTP Request */
        return $this->cache->get('mixes_data',function (CacheItemInterface $cacheItem) {

            /**
             * Manage caching during debug mode.
             * see config/services.yaml
             */
            $cacheItem->expiresAfter($this->isDebug ? 5 : 60);
            $response = $this->githubContentClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json',[
                'headers' => ['Authorization' => 'Token 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']
            ]);
            return $response->toArray();
        });
    }
}