<?php

class Todo
{
    private int|null $id;
    private string $task = "";
    private bool $is_complated = true;

    // コンストラクター
    public function __construct(int $id = null, string $task, bool $is_complated)
    {
        $this->id = $id;
        $this->task = htmlspecialchars($task);
        $this->is_complated = $is_complated;
    }

    /**
     * ID取得
     *
     * @return integer|null
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * タスク取得
     *
     * @return string
     */
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * 完了・未完了フラグ取得
     *
     * @return boolean
     */
    public function getIsComplated(): bool
    {
        return $this->is_complated;
    }
}
