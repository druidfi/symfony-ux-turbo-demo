<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Room;
use App\Repository\MessageRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/rooms', name: 'rooms')]
    public function index(RoomRepository $roomRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    #[Route('/rooms/create', name: 'create_room')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $room = new Room();
        $form = $this->createFormBuilder($room)
            ->setAction($request->getPathInfo())
            ->add('name', TextType::class, ['attr' => ['autocomplete' => 'off']])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('rooms', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/create.html.twig', ['form' => $form]);
    }

    #[Route('/rooms/{id}/rename', name: 'rename_room')]
    public function rename(Request $request, Room $room, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder($room)
            ->setAction($request->getPathInfo())
            ->add('name', TextType::class, ['attr' => ['autocomplete' => 'off']])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('view_room', ['id' => $room->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/rename.html.twig', ['form' => $form]);
    }

    #[Route('/rooms/{id}', name: 'view_room')]
    public function view(Request $request, Room $room, MessageRepository $messageRepository, EntityManagerInterface $entityManager): Response
    {
        $message = (new Message())->setRoom($room);

        $form = $this->createFormBuilder($message)
            ->add('text', TextType::class, ['attr' => ['autocomplete' => 'off', 'autofocus' => true]])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('view_room', ['id' => $room->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/view.html.twig', [
            'room' => $room,
            'messages' => $messageRepository->findBy(['room' => $room]),
            'form' => $form
        ]);
    }
}
