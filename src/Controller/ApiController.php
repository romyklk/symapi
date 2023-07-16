<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;



class ApiController extends AbstractController
{

    #[Route('/', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig');
    }

    #[Route('/region', name: 'app_api_region', methods: ['GET'])]
    public function region(SerializerInterface $serializerInterface, PaginatorInterface $paginator, Request $request)
    {
        //SerializerInterface est une interface qui permet de convertir des données en json
        $regions = file_get_contents('https://geo.api.gouv.fr/regions');

        // convertir le json en tableau
        //$regions = $serializerInterface->decode($regions, 'json');
        //dd($regions);

        //Dénormalisation
        // denormalize() permet de convertir un tableau en objet. il faut lui passer le tableau et le type d'objet . Ici ce sera un tableau d'objets de type Region
        //$regionsObj = $serializerInterface->denormalize($regions, 'App\Entity\Region[]'); 
        //dd($regionsObj);

        // deserialise() permet de convertir un tableau en objet. il faut lui passer le tableau et le type d'objet . Ici ce sera un tableau d'objets de type Region

        $regionObj = $serializerInterface->deserialize($regions, 'App\Entity\Region[]', 'json'); // deserialize() permet de convertir un json en objet. il faut lui passer le json et le type d'objet . Ici ce sera un tableau d'objets de type Region

        //dd($regionObj);

        // Pagination
        $pagination = $paginator->paginate(
            $regionObj,
            $request->query->getInt('page', 1), // Récupère le numéro de page à partir de la requête, par défaut 1
            6 // Nombre d'éléments par page
        );

        return $this->render('api/regions.html.twig', [
            'regions' => $pagination,
        ]);
    }

    #[Route('/departement', name: 'app_api_departement')]
    public function departement(Request $request,SerializerInterface $serializerInterface, PaginatorInterface $paginator)
    {
        // Je récupère le code de la région dans l'url
        $codeRegion = $request->query->get('region');

        // Je récupère les régions
        $regions = file_get_contents('https://geo.api.gouv.fr/regions');
        $regionsObj = $serializerInterface->deserialize($regions, 'App\Entity\Region[]', 'json');

        // Je récupère les départements
        if($codeRegion == null || $codeRegion == 'toutes'){
            $departements = file_get_contents('https://geo.api.gouv.fr/departements');
        
        }else{
            $departements = file_get_contents('https://geo.api.gouv.fr/regions/'.$codeRegion.'/departements');
        }

        // Puisseque j'ai pas d'entité departement, je ne peux pas utiliser deserialize() ou denormalize(). Pour cela, j'utilise decode() qui permet de convertir le json en tableau

        $departementsTab = $serializerInterface->decode($departements, 'json');
        
        $departementsObj = $serializerInterface->deserialize($departements, 'App\Entity\Departement[]', 'json');

        //pagination
         $pagination = $paginator->paginate(
            $departementsObj,$request->query->getInt('page', 1), 12 ); 

        
        

        return $this->render('api/departements.html.twig', [
            'regions' => $regionsObj,
            'departements' => $pagination
        ]);
    }


    #[Route('/commune', name: 'app_api_commune')]
    public function commune(Request $request,SerializerInterface $serializerInterface, PaginatorInterface $paginator)
    {
        // Récupérer tous les départements
        $departements = file_get_contents('https://geo.api.gouv.fr/departements');
        $departementTab = $serializerInterface->decode($departements, 'json');

        // Récupérer le code du département dans l'url
        $codeDepartement = $request->query->get('departement');

        // Récupérer les communes
        if($codeDepartement == null || $codeDepartement == 'toutes'){
            $communes = file_get_contents('https://geo.api.gouv.fr/communes');
        }else{
            $communes = file_get_contents('https://geo.api.gouv.fr/departements/'.$codeDepartement.'/communes');
        }

        $communesTab = $serializerInterface->decode($communes, 'json');

        //dd($communesTab);
        $communesObj = $serializerInterface->deserialize($communes, 'App\Entity\Commune[]', 'json');

        //dd($communesObj);

        //pagination
        $pagination = $paginator->paginate(
            $communesObj,
            $request->query->getInt('page', 1),
            15
        ); 





        return $this->render('api/communes.html.twig',
        [
            'departements' => $departementTab,
            'communes' => $pagination
        ]);
    }
}
