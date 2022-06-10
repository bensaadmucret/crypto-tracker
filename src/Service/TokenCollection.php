<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Token;
use Doctrine\Persistence\ManagerRegistry;




class TokenCollection

{
    private $tokens;

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    public function getTokens(): array
    {
        return $this->tokens;
    }

    // getname in array
    public function getName(): array
    {
        $name = [];
        foreach ($this->tokens as $token) {
           $name[] = $token->getName();
        }
        /*foreach ($this->tokens['data'] as $token) {
            $name[] = $token['name'];

        }*/
        return $name;
    }

    public function getPrice(): array
    {
        $price = [];

        foreach ($this->tokens['data'] as $token) {
            
           foreach ($token['quote'] as $key => $value) {
               if ($key == 'EUR') {
                   $price[] = $value['price'];
               }
           }

        }
        return $price;
    }

    public function getPriceChange(): array
    {
        $priceChange = [];

        foreach ($this->tokens['data'] as $token) {
            
           foreach ($token['quote'] as $key => $value) {
               if ($key == 'EUR') {
                   $priceChange[] = $value['percent_change_24h'];
               }
           }

        }
        return $priceChange;
    }

    public function getAll()
    {
        $allTokens = [];
        foreach ($this->tokens['data'] as $token) {
            $allTokens[] = (object)[
                'name' => $token['name'],
                'slug' => $token['slug'],
                'symbol' => $token['symbol'],
                'price' => $token['quote']['EUR']['price'],
                'percent_change_24h' => $token['quote']['EUR']['percent_change_24h'],
                'percent_change_1h' => $token['quote']['EUR']['percent_change_1h'],
                'percent_change_7d' => $token['quote']['EUR']['percent_change_7d'],

            ];
        }
        return $allTokens;
    }

    public function getTokenByName(string $name)
    {
        foreach ($this->tokens['data'] as $token) {
            if ($token['name'] == $name) {
                return (object)[
                    'name' => $token['name'],
                    'slug' => $token['slug'],
                    'symbol' => $token['symbol'],
                    'price' => $token['quote']['EUR']['price'],
                    'percent_change_24h' => $token['quote']['EUR']['percent_change_24h'],
                    'percent_change_1h' => $token['quote']['EUR']['percent_change_1h'],
                    'percent_change_7d' => $token['quote']['EUR']['percent_change_7d'],

                ];
            }
        }
    }


    // sauvegarde dans la base de données
    public function save(ManagerRegistry $managerRegistry)
    {
        if(!$managerRegistry->getRepository(Token::class)->findAll()) {
            foreach ($this->tokens['data'] as $token) {
                $newToken = new Token();
                $newToken->setName($token['name']);
                $newToken->setSlug($token['slug']);
                $newToken->setSymbol($token['symbol']);
                $newToken->setPrice($token['quote']['EUR']['price']);
                $newToken->setChange24h($token['quote']['EUR']['percent_change_24h']);
                $newToken->setChange1h($token['quote']['EUR']['percent_change_1h']);
                $newToken->setChange7d($token['quote']['EUR']['percent_change_7d']);
                $managerRegistry->getManager()->persist((object)$newToken);
            }
            $managerRegistry->getManager()->flush();
        }
        // sinon mettre a jour le priceChange
        else {
            foreach ($this->tokens['data'] as $token) {
                $newToken = $managerRegistry->getRepository(Token::class)->findOneBy(['name' => $token['name']]);
                $newToken->setPrice($token['quote']['EUR']['price']);
                $newToken->setChange24h($token['quote']['EUR']['percent_change_24h']);
                $newToken->setChange1h($token['quote']['EUR']['percent_change_1h']);
                $newToken->setChange7d($token['quote']['EUR']['percent_change_7d']);
                $managerRegistry->getManager()->persist((object)$newToken);
            }
            $managerRegistry->getManager()->flush();
        }

    }
    
}