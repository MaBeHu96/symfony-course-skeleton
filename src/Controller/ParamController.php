<?php 

declare(strict_types=1);


namespace App\Controller;



use BcMath\Number;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// Para poder ver las rutas en el contenedos de la consolo se corre el comando  bin/console debug:router para poder ver las rutas de los controladores creados 

#[Route('/params')]
class ParamController extends AbstractController
{
    #[Route('/query', name: 'get-query-params', methods: ['GET'])]
    public function getQueryParams(Request $request): Response
    {
        $name = $request->query->get( key: 'name');
        $email = $request->query->get( key: 'email');

        $items = ['one', 'two', 'three', 'four'];

        // IMPORTANTE 
        /*
          es muy importante que en php se tiene que declarar los argumentos 
          dentro del render es decir si declaro view y voy a usar un array de parametros tengo que declarar 
          tambien parameters y si no declaro alguno no se declara ninguno ... En render(), el primer argumento (view) es nombrado, y el segundo ([ ... ]) lo estás pasando como posicional.
En PHP, si empiezas con argumentos con nombre, todos los siguientes también deben tener nombre.
        */
        return $this->render(view: 'params/params.html.twig',parameters: [
            'name' => $name,
            'email' => $email,
            'items' => $items,
        ]);
        


        // return new JsonResponse([
        //     'name' =>  $name,
        //     'email' =>  $email
        // ]);
    }

    #[Route('/attributes/{name}/{email}/{numero}', name: 'get-from-attributes', methods: ['GET'])]
    public function getFromAttributes( $name, string $email,  int $numero): Response   //Recomended aproach
    // public function getFromAttributes(Request $request): Response  //Normal approach
    {
    
        // Normal Approach
        // $name = $request->attributes->get(key: 'name');
        // $email = $request->attributes->get(key: 'email');

        // Recommended approach

        return new JsonResponse([
            'name' => $name,
            'email' => $email,
            'numero' => $numero,
        ]);
    }

    #[Route('/body', name: 'get-from-body', methods: ['POST'])]
    public function getFromBody(Request $request):Response
    {
        $request->request = new ParameterBag(json_decode($request->getContent(), associative:true));


        return new JsonResponse([
            'name' => $request->request->get(key:'name'),
            'email' => $request->request->get(key:'email'),
        ]);
    }
}

