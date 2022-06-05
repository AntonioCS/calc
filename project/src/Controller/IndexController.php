<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\Calculator\CalcData;
use App\Form\CalculatorType;
use App\Service\Calculator\Calculator;
use App\Service\Calculator\Operations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    public function __construct(
        private Calculator $calculator
    )
    {
    }

    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        $calcData = new CalcData();
        $form = $this->createForm(CalculatorType::class, $calcData);
        $result = null;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CalcData $calcData */
            $calcData = $form->getData();

            try {
                $op = $this->operationConverter($calcData->getOperation());
                $result = $this->calculator->calculate($calcData->getValueA(), $calcData->getValueB(), $op);
            } catch (\Throwable $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'result' => $result
        ]);
    }

    private function operationConverter(string $op): Operations
    {
        return match ($op) {
            Operations::Add->value => Operations::Add,
            Operations::Subtract->value => Operations::Subtract,
            Operations::Multiply->value => Operations::Multiply,
            Operations::Divide->value => Operations::Divide
        };
    }
}
