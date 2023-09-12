<?php

namespace Orvital\Support\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Inspired by https://github.com/korridor/laravel-model-validation-rules
 */
class ExistsEloquent implements ValidationRule
{
    /**
     * Class name of model.
     */
    private string $model;

    /**
     * Relevant key in the model.
     */
    private ?string $key;

    /**
     * Closure that can extend the eloquent builder.
     */
    private ?Closure $builderClosure;

    /**
     * Custom validation message.
     */
    private ?string $customMessage = null;

    /**
     * Custom translation key for message.
     */
    private ?string $customMessageTranslationKey = null;

    /**
     * Create a new rule instance.
     */
    public function __construct(string $model, string $key = null, Closure $builderClosure = null)
    {
        $this->model = $model;
        $this->key = $key;
        $this->setBuilderClosure($builderClosure);
    }

    /**
     * Set a custom validation message.
     */
    public function withMessage(string $message): self
    {
        $this->customMessage = $message;

        return $this;
    }

    /**
     * Set a translated custom validation message.
     */
    public function withCustomTranslation(string $translationKey): self
    {
        $this->customMessageTranslationKey = $translationKey;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $builder = new $this->model();
        $modelKeyName = $builder->getKeyName();
        $builder = $builder->where($this->key === null ? $modelKeyName : $this->key, $value);

        if ($this->builderClosure !== null) {
            $builderClosure = $this->builderClosure;
            $builder = $builderClosure($builder);
        }

        if ($builder->doesntExist()) {
            if ($this->customMessage !== null) {
                $fail($this->customMessage);
            } else {
                $fail($this->customMessageTranslationKey ?? 'support::validation.exists_model')->translate([
                    'attribute' => $attribute,
                    'model' => strtolower(class_basename($this->model)),
                    'value' => $value,
                ]);
            }
        }
    }

    /**
     * Set a closure that can extend the eloquent builder.
     */
    public function setBuilderClosure(?Closure $builderClosure): void
    {
        $this->builderClosure = $builderClosure;
    }

    public function query(Closure $builderClosure): self
    {
        $this->setBuilderClosure($builderClosure);

        return $this;
    }
}
