<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Developer;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\News;
use App\Entity\Platform;
use App\Entity\Publisher;
use App\Entity\Review;
use App\Entity\Tag;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    private string $backendUrl;
    private string $frontendUrl;

    public function __construct(string $backendUrl, string $frontendUrl)
    {
        $this->backendUrl = $backendUrl;
        $this->frontendUrl = $frontendUrl;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->render('admin/dashboard.html.twig', [
            'links' => [
                [
                    'title' => 'Site',
                    'icon' => 'fa-solid fa-city',
                    'url' => $this->frontendUrl . '/',
                ],
                [
                    'title' => 'News',
                    'icon' => 'fa-solid fa-rocket',
                    'url' => $adminUrlGenerator->setController(NewsCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Reviews',
                    'icon' => 'fa-solid fa-brain',
                    'url' => $adminUrlGenerator->setController(ReviewCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Games',
                    'icon' => 'fa-solid fa-gamepad',
                    'url' => $adminUrlGenerator->setController(GameCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Users',
                    'icon' => 'fa-solid fa-user',
                    'url' => $adminUrlGenerator->setController(UserCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Comments',
                    'icon' => 'fa-solid fa-comment',
                    'url' => $adminUrlGenerator->setController(CommentCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Tags',
                    'icon' => 'fa-solid fa-tag',
                    'url' => $adminUrlGenerator->setController(TagCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Genres',
                    'icon' => 'fa-solid fa-book',
                    'url' => $adminUrlGenerator->setController(GenreCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Developers',
                    'icon' => 'fa-solid fa-user-secret',
                    'url' => $adminUrlGenerator->setController(DeveloperCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Publishers',
                    'icon' => 'fa-solid fa-robot',
                    'url' => $adminUrlGenerator->setController(PublisherCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Platforms',
                    'icon' => 'fa-solid fa-desktop',
                    'url' => $adminUrlGenerator->setController(PlatformCrudController::class)->generateUrl(),
                ],
                [
                    'title' => 'Documentation',
                    'icon' => 'fa-solid fa-file',
                    'url' => $this->backendUrl . '/api/doc',
                ],
                [
                    'title' => 'Stats',
                    'icon' => 'fa-solid fa-chart-column',
                    'url' => $this->backendUrl . '/stats',
                ],
            ],
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GremSymfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-gear');
        yield MenuItem::linkToUrl('Site', 'fa-solid fa-city', $this->frontendUrl . '/');
        yield MenuItem::linkToCrud('News', 'fa-solid fa-rocket', News::class);
        yield MenuItem::linkToCrud('Reviews', 'fa-solid fa-brain', Review::class);
        yield MenuItem::linkToCrud('Games', 'fa-solid fa-gamepad', Game::class);
        yield MenuItem::linkToCrud('Users', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Comments', 'fa-solid fa-comment', Comment::class);
        yield MenuItem::linkToCrud('Tags', 'fa-solid fa-tag', Tag::class);
        yield MenuItem::linkToCrud('Genres', 'fa-solid fa-book', Genre::class);
        yield MenuItem::linkToCrud('Developers', 'fa-solid fa-user-secret', Developer::class);
        yield MenuItem::linkToCrud('Publishers', 'fa-solid fa-robot', Publisher::class);
        yield MenuItem::linkToCrud('Platforms', 'fa-solid fa-desktop', Platform::class);
        yield MenuItem::linkToUrl('Documentation', 'fa-solid fa-file', $this->backendUrl . '/api/doc');
        yield MenuItem::linkToUrl('Stats', 'fa-solid fa-chart-column', $this->backendUrl . '/stats');
    }
}
