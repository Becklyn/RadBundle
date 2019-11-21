<?php declare(strict_types=1);

namespace Becklyn\RadBundle\Controller;

use Becklyn\RadBundle\Exception\EntityRemovalBlockedException;
use Becklyn\RadBundle\Exception\LabeledEntityRemovalBlockedException;
use Becklyn\RadBundle\Form\FormErrorMapper;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Base class for all controllers.
 */
abstract class BaseController extends AbstractController
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedServices () : array
    {
        return \array_replace(parent::getSubscribedServices(), [
            LoggerInterface::class,
            TranslatorInterface::class,
        ]);
    }


    /**
     *
     */
    protected function trans (string $id, array $parameters = [], ?string $domain = null, ?string $locale = null) : string
    {
        return $this->get(TranslatorInterface::class)->trans($id, $parameters, $domain, $locale);
    }


    /**
     * Fetches the Entity remove message from an exception.
     */
    protected function getEntityRemovalMessage (\Exception $exception) : string
    {
        switch (true)
        {
            case $exception instanceof LabeledEntityRemovalBlockedException:
                $message = $exception->getFrontendMessage();
                break;

            case $exception instanceof EntityRemovalBlockedException:
                $message = "entity_removal.failed.generic_blocked";
                break;

            case $exception->getPrevious() instanceof ForeignKeyConstraintViolationException:
            case $exception instanceof ForeignKeyConstraintViolationException:
                // this entity is still referenced
                $message = "entity_removal.failed.foreign_key";
                break;

            default:
                // unknown cause of failed removal
                // -> use generic error message
                $message = "entity_removal.failed.generic";
                // -> log the error
                $this->get(LoggerInterface::class)->error("Removal of an entity failed due to unspecified reasons.", [
                    "exception" => $exception,
                ]);
                break;
        }

        return $this->trans($message, [], "backend");
    }


    /**
     * Returns the form error mapping for the given form.
     */
    protected function getFormErrorMapping (FormInterface $form) : array
    {
        $mapper = new FormErrorMapper($this->get(TranslatorInterface::class));
        return $mapper->generate($form);
    }
}
