<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Entity\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Doctrine\DBAL\Query\QueryBuilder;

/**
 * @Route("/", name="default")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->getDoctrine()->getConnection();

        $qb = $connection->createQueryBuilder();
        $qb->select('game.id', 'game.name')->from('game', 'game');
        $qb->orderBy('game.id');
        $game = $qb->execute()->fetchAll();

        return $this->render('default/index.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/game", name="game", methods={"GET","POST"})
     */
    public function game(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $players = $request->request->get('player');
            $gameName = $request->request->get('game');
            $game = new Game();
            $game->setName($gameName);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($game);
            $manager->flush();

            foreach ($players as $player) {
                if (empty($player)) {
                    continue;
                }
                $playerEntity = new Player();
                $playerEntity->setName($player);
                $playerEntity->setGame($game->getId());
                $playerEntity->setPoints(0);
                $manager->persist($playerEntity);
            }
            $manager->flush();
            return $this->redirectToRoute('defaultplay', ['id' => $game->getId()]);
        }

        return $this->render('default/game.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/play/{id}", name="play")
     * @Route("/play/{id}/{playerId}", name="play", methods={"GET","POST"})
     */
    public function play(Request $request, int $id, ?int $playerId = null)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->getDoctrine()->getConnection();

        if ($request->getMethod() === 'POST') {
            $result = new Result();
            $result->setGameId($id);
            $result->setPlayerId($request->request->get('playerId'));
            $result->setBuzzwordId($request->request->get('buzzwordId'));
            if ($request->request->get('answer') > 0) {
                $result->setPoints($request->request->get('points'));
            } else {
                $result->setPoints(0);
            }
            $this->getDoctrine()->getManager()->persist($result);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('defaultplay', ['id' => $id, 'playerId' => $playerId]);
        }

        $resultQuery = $connection->createQueryBuilder();
        $resultQuery->select('SUM(result.points)');
        $resultQuery->from('result', 'result');
        $resultQuery->where($resultQuery->expr()->eq('result.player_id', 'player.id'));

        $query = $connection->createQueryBuilder();
        $query->select([
            'player.id',
            'player.name',
            'IF(player.id = :playerId,1,0) as active',
            '(' . $resultQuery->getSQL() . ') as result',
        ]);
        $query->from('player', 'player');
        $query->where($query->expr()->eq('player.game', ':gameId'));
        $query->setParameter('gameId', $id);
        $query->setParameter('playerId', $playerId);
        $query->orderBy('player.id');

        $players = [];
        foreach ($query->execute()->fetchAll() as $player) {
            $player['result'] = (int)$player['result'];
            $players[$player['id']] = $player;
        }

        if ($playerId !== null) {
            $current = $playerId;
            while (key($players) !== $current) {
                next($players);
            }
        } else {
            $player = reset($players);
            $current = (int)$player['id'];
            $players[$current]['active'] = 1;
        }
        $nextPlayer = next($players);

        if (!$nextPlayer) {
            $nextPlayer = reset($players);
        }

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->getDoctrine()->getConnection();
        $qb = $connection->createQueryBuilder();
        $qb->select([
            'buzzword.id',
            'buzzword.title',
            'buzzword.points',
            'buzzword.description',
            'buzzword.catgory',
            'IF(result.id > 0,1,0) as played'
        ]);

        $qb->from('buzzword', 'buzzword');
        $qb->leftJoin('buzzword', 'result', 'result',
            $qb->expr()->andX(
                $qb->expr()->eq('result.buzzword_id', 'buzzword.id'),
                $qb->expr()->eq('result.game_id', ':gameId')
            )
        );
        $qb->orderBy('buzzword.points', 'ASC');
        $qb->setParameter('gameId', $id);
        $buzzwords = [];
        foreach ($qb->execute()->fetchAll() as $result) {
            $buzzwords[$result['catgory']][] = $result;
        }

        return $this->render('default/play.html.twig', [
            'players' => $players,
            'category' => $buzzwords,
            'current' => $current,
            'next' => $nextPlayer['id'],
            'game' => $id
        ]);
    }
}
