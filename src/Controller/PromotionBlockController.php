<?php

namespace Drupal\promotion_block\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\RendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Implementing Promotion block JSON APi.
 */
class PromotionBlockController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public function __construct(RendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('renderer')
    );
  }

  /**
   * Callback for the API.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Return response with popup settings.
   */
  public function renderApi() {

    $response = new JsonResponse([
      'data' => $this->getResults(),
      'method' => 'GET',
    ]);

    $cur_time = time();
    $cookie = new Cookie(PROMOTION_BLOCK_COOKIE_NAME, $cur_time, $cur_time + PROMOTION_BLOCK_COOKIE_LIFETIME, '/');
    $response->headers->setCookie($cookie);
    $response->sendHeaders();

    return $response;
  }

  /**
   * A helper function returning results.
   */
  public function getResults() {
    $config = $this->config('promotion_block.settings');

    if ($config->get('enable')) {
      $build = [
        '#type' => 'processed_text',
        '#text' => $config->get('description.value'),
        '#format' => $config->get('description.format'),
      ];
      $description = $this->renderer->renderPlain($build);

      return [
        'title' => $config->get('title'),
        'html' => $description,
        'dialogClass' => 'promotion-block-dialog',
        'close' => '',
        'cookie_name' => PROMOTION_BLOCK_COOKIE_NAME,
        'expire_seconds' => PROMOTION_BLOCK_COOKIE_LIFETIME,
        'width' => '80%',
      ];
    }

    return [];
  }

}
