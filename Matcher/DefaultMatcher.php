<?php

namespace Success\InviteBundle\Matcher;

use Success\InviteBundle\Manager\RefererManager;
use Symfony\Component\HttpFoundation\Request;

class DefaultMatcher implements MatcherInterface {

  /**
   * @var RefererManager $manager
   */
  protected $manager;

  /**
   * @var string
   */
  protected $field;

  /**
   * Class constructor
   *
   * @param RefererManager $manager
   * @param string $field
   */
  public function __construct(RefererManager $manager, $field) {
    $this->manager = $manager;
    $this->field = $field;
  }

  /**
   * Return RefererInterface match
   *
   * @param  Request $request
   * @return RefererInterface
   */
  public function match(Request $request) {
    if ($request->request->has($this->field)) {
      $slug = base64_decode($request->get($this->field));
      if ($slug) {
        $repo = $this->manager->getRepository();
        return $repo->findOneBySlug($slug);
      }
    }
    return null;
  }

}