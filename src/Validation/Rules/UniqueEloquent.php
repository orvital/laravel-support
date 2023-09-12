<?php

namespace Orvital\Support\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Inspired by https://github.com/korridor/laravel-model-validation-rules
 */
class UniqueEloquent implements ValidationRule
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
     * Closure that can extend the eloquent builder
     */
    private ?Closure $builderClosure;

    private mixed $ignoreId = null;

    private ?string $ignoreColumn = null;

    /**
     * Custom validation message.
     */
    private ?string $customMessage = null;

    /**
     * Translation key for custom validation message.
     */
    private ?string $customMessageTranslationKey = null;

    /**
     * UniqueEloquent constructor.
     */
    public function __construct(string $model, string $key = null, Closure $builderClosure = null)
    {
        $this->model = $model;
        $this->key = $key;
        $this->setBuilderClosure($builderClosure);
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

        if ($this->ignoreId !== null) {
            $builder = $builder->where(
                $this->ignoreColumn === null ? $modelKeyName : $this->ignoreColumn,
                '!=',
                $this->ignoreId
            );
        }

        if ($builder->exists()) {
            if ($this->customMessage !== null) {
                $fail($this->customMessage);
            } else {
                $fail($this->customMessageTranslationKey ?? 'support::validation.unique_model')->translate([
                    'attribute' => $attribute,
                    'model' => strtolower(class_basename($this->model)),
                    'value' => $value,
                ]);
            }
        }
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

    public function setIgnore(mixed $id, string $column = null): void
    {
        $this->ignoreId = $id;
        $this->ignoreColumn = $column;
    }

    public function ignore(mixed $id, string $column = null): self
    {
        $this->setIgnore($id, $column);

        return $this;
    }
}
